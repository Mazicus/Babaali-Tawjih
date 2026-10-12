# Babaali Tawjih

An education orientation portal for students exploring schools, institutes and universities in Morocco. Browse the institution catalogue, save favorite schools and manage your account from a personal dashboard.

**Website:** [babaali-tawjih.vercel.app](https://babaali-tawjih.vercel.app)

> This is the configured deployment address. The Laravel version has been verified locally; production deployment, hosted database migration, Google sign-in and recovery email delivery still require verification.

## Features

- Institution catalogue with photographs and source metadata.
- Registration, password login and a personal dashboard.
- School favorites saved separately for each account.
- Profile editing and private profile photo uploads.
- Contact form submissions.
- Google sign-in and account linking when OAuth credentials are configured.
- Password recovery through Resend when a verified sender is configured.

## Technology

| Layer | Technology |
| --- | --- |
| Backend | Laravel 13, PHP 8.3+, Eloquent |
| Templates and frontend | Blade, CSS and JavaScript |
| Institution catalogue | Shared JSON files |
| Database | MySQL-compatible hosting; SQLite for local development |
| Authentication | Laravel authentication, database sessions, Google OAuth with PKCE |
| Email | Resend |
| Deployment | Vercel with the community `vercel-php@0.9.0` runtime |

## Run locally

Install PHP 8.3+ and Composer. Enable PDO, mbstring, OpenSSL, cURL and fileinfo, plus `pdo_sqlite` for the setup below. Node.js is needed only for the JavaScript checks.

From the project directory, run these commands in PowerShell:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database/database.sqlite -Force
```

Set these values in `.env`:

```dotenv
APP_ENV=local
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
```

Leave `DB_DATABASE` unset to use `database/database.sqlite`. Then start the application:

```powershell
php artisan migrate
php artisan serve
```

Open [localhost:8000](http://localhost:8000). Google sign-in and recovery email require the provider settings below.

For local MySQL, enable `pdo_mysql`, set `DB_CONNECTION=mysql` and provide `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` and `DB_PASSWORD`. The aliases `DB_DATABASE` and `DB_USERNAME` are also supported.

## Deploy to Vercel

The repository includes `vercel.json` and `api/index.php`. Website requests pass through Laravel, public assets are served from `public/`, and writable runtime files use temporary storage. Sessions and cache use the hosted database.

Configure the following project environment variables:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://babaali-tawjih.vercel.app
APP_KEY=<generated-application-key>
DB_CONNECTION=mysql
DB_HOST=<database-host>
DB_PORT=3306
DB_NAME=<database-name>
DB_USER=<database-user>
DB_PASSWORD=<database-password>
SESSION_DRIVER=database
SESSION_TABLE=laravel_sessions
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
DB_CACHE_TABLE=laravel_cache
DB_CACHE_LOCK_TABLE=laravel_cache_locks
QUEUE_CONNECTION=sync
```

Generate the production key with `php artisan key:generate --show`, store it privately and keep it stable between deployments. Do not commit `.env` or provider secrets.

Back up the hosted database, then run `php artisan migrate --force` once from a trusted PHP environment configured for that database before serving the deployment. The adoption migration preserves existing accounts and application data. **Do not use `migrate:fresh` on an existing database.** Prior sessions and old reset links require a fresh login or recovery request; reverting the adoption migration requires restoring a verified backup.

For TiDB Cloud, the application can use the bundled CA certificate. Other providers can supply CA PEM through `DB_SSL_CA` or a readable certificate path through `MYSQL_ATTR_SSL_CA`.

After deployment, verify registration, login, favorites, profile updates and contact submission against the hosted database.

### Google sign-in

Create a Google OAuth Web application client and register this exact redirect URI:

```text
https://babaali-tawjih.vercel.app/google-callback.php
```

Set `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` and `GOOGLE_REDIRECT_URI`. Configure the consent screen and test users as required by your Google project. For local use, register the corresponding localhost callback URL.

Account linking requires an authenticated session with the same email. Test a real Google account after configuring the provider.

### Password recovery

Set `MAIL_MAILER=resend`, `RESEND_API_KEY` and `RECOVERY_EMAIL_FROM` to a verified sender address. `MAIL_FROM_ADDRESS` is also supported. Keep `APP_URL` set to the public website URL so recovery links point to the correct deployment.

Recovery tokens expire after 30 minutes and become invalid after a successful reset. Test actual delivery after configuring the sender in Resend.

## Project structure

```text
app/                 Controllers, models and application logic
api/index.php        Vercel entry point
config/              Application and provider configuration
database/            Data-preserving migrations
public/              Public assets and Laravel entry point
resources/views/     Blade page templates
routes/web.php       Website routes
tests/              PHP and JavaScript checks
```

The web server document root must be `public/`. Addresses such as `/login.php` and `/Dashboard.php` are Laravel routes retained for compatibility.

## Verification

```powershell
php artisan test
node --testtests/dashboard-ui.cjstests/navigation.cjs
composer validate --no-check-publish
```

The tests cover authentication, legacy password compatibility, account-isolated favorites, avatars, recovery, Google OAuth, CSRF protection, contact submissions and data-preserving migrations. Tests use an isolated SQLite database and mocked provider calls; they do not verify hosted MySQL or live provider services.

## Scope and supporting documentation

School and user administration, application tracking, calendars, personalized follow-up and notifications are outside the current implementation.

- [Laravel report updates](RAPPORT-LARAVEL.md): French material describing the backend migration.
- [Implementation scope and remaining checks](REPORT-GAPS.md): implemented features and outstanding verification.

