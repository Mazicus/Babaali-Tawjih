# Babaali Tawjih — Laravel backend

The existing website now runs on Laravel 13. Its homepage, login, registration, dashboard, school photographs and shared school renderer are retained. Account authentication, favorites, profile photos, contact submissions, Google OAuth and password recovery use Laravel routes, controllers and Eloquent models.

## Local setup

Requires PHP 8.3+ with PDO, mbstring, OpenSSL, cURL and fileinfo, plus Composer. Use pdo_mysql for the hosted database or pdo_sqlite for a local database. PHP 8.0 from the previous XAMPP installation cannot run this application.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
# Set database credentials in .env before the next command.
php artisan migrate
php artisan serve
```

This workspace also has an ignored portable PHP runtime under `.tools/php/` and Composer under `.tools/composer.phar`; they are local conveniences and are not deployed. The current local `.env` uses an isolated SQLite database. For a fresh SQLite setup, create `database/database.sqlite`, set `DB_CONNECTION=sqlite` and `DB_DATABASE` to its absolute path, then migrate.

The web server document root must be `public/`. Frontend files moved there, and templates now live in `resources/views/`. Existing links such as `/index.html`, `/login.php` and `/Dashboard.php` are Laravel routes, not separate executable scripts. Logout uses a protected POST form; a GET to the old logout address returns to the dashboard.

## Database and existing accounts

The adoption migration creates missing tables and adds `users.remember_token` and `users.auth_version`. It preserves existing users, password hashes, favorites, avatar images, Google associations and contact messages. Existing authentication versions are copied when available. Existing sessions and old password-reset links are not imported; users sign in again and request fresh recovery links.

Use `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` for the existing hosted setup. Laravel's `DB_DATABASE` and `DB_USERNAME` aliases are also supported. A bundled CA certificate is used for TiDB Cloud; another provider can supply its full CA PEM in `DB_SSL_CA` or a readable certificate path in `MYSQL_ATTR_SSL_CA`.

Back up the hosted database before running `php artisan migrate --force` with its credentials. Run migrations once from a trusted PHP environment before serving the new deployment. Do not use `migrate:fresh`, which deletes tables. This adoption migration intentionally cannot be rolled back destructively; restore a verified backup when reverting. Old SQL files are historical references, not the installation procedure for this Laravel version.

## Vercel deployment

`api/index.php` initializes Laravel through `public/index.php`. The community `vercel-php@0.9.0` runtime installs locked Composer dependencies. Vercel routes expose public assets and send website requests to Laravel, while blocking application source directories. Writable runtime storage uses the temporary directory; sessions and rate limits remain database-backed.

Set these project environment variables before deploying:

- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://babaali-tawjih.vercel.app`.
- A stable `APP_KEY` generated with `php artisan key:generate --show`; store it privately and keep it unchanged between deployments.
- Hosted database credentials described above, `DB_CONNECTION=mysql`.
- `SESSION_DRIVER=database`, `SESSION_TABLE=laravel_sessions`, `SESSION_SECURE_COOKIE=true`.
- `CACHE_STORE=database`, `DB_CACHE_TABLE=laravel_cache`, `DB_CACHE_LOCK_TABLE=laravel_cache_locks`, `QUEUE_CONNECTION=sync`.

No production deployment or hosted database migration was performed as part of this source migration. Existing production credentials alone do not replace the required new APP_KEY and infrastructure migration.

## Google connection

Create a Google OAuth **Web application** client with the authorized redirect URI `https://babaali-tawjih.vercel.app/google-callback.php`. Configure branding, consent and test users in Google Auth Platform. Set `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` in Vercel; the redirect URI must match exactly. For local testing register a corresponding localhost URL.

Google login checks session state, uses PKCE, requires a verified email and stores only the Google subject association. Existing password accounts are linked only from an authenticated session with the same email. Missing configuration produces a clear message. Activation and real-account verification still require the Google client.

## Password recovery

Resend is the configured Laravel mail transport. Set `MAIL_MAILER=resend`, `RESEND_API_KEY` and `RECOVERY_EMAIL_FROM` to a verified sender address, plus the production APP_URL. `MAIL_FROM_ADDRESS` can replace the sender alias. Configure the sender domain in Resend before testing delivery.

Reset tokens expire after 30 minutes and are consumed after a successful reset. Public recovery responses do not reveal whether an account exists. Resetting rotates the remembered-login token and account session version. Live delivery has not been verified without provider credentials.

## Checks and rapport

```powershell
php artisan test
node --test tests/dashboard-ui.cjs tests/navigation.cjs
composer validate --no-check-publish
```

Tests cover legacy password compatibility, registration, account-isolated favorites, private avatar uploads, password resets, native email notifications, Google state/PKCE/linking, CSRF, contact submission and data-preserving migration. Provider calls and email notifications are mocked; tests use an isolated SQLite database. Hosted MySQL and real provider integration need deployment checks.

See `RAPPORT-LARAVEL.md` for the French report updates and `REPORT-GAPS.md` for remaining scope limits. The original Word report has not been edited. The old standalone PHP files remain only in an ignored local `legacy/` directory; active code does not load them.
