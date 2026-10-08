# Babaali Tawjih on Vercel

See REPORT-GAPS.md for the prototype scope and differences from the supplied internship report. The user chose to publish this existing prototype with gaps documented.

This copy is prepared for Vercel using the community vercel-php 0.9.0 runtime.
The prepared database instance is in Tokyo; the function region is set to hnd1. A public ISRG Root X1 CA certificate is bundled under config/ for verified TLS to TiDB. DB_SSL_CA can override it for another provider.
The homepage is index.html. PHP pages are served through api/index.php.
Login sessions use MySQL rather than temporary server files.
Your original XAMPP project has not been modified.

## Before deploying

1. Create a hosted MySQL database reachable from Vercel. XAMPP on your computer is not an online database.
2. Run database/schema.sql in the hosted database SQL editor. This initializes a new database; it does not migrate existing users or contact messages.
3. In Vercel Project Settings > Environment Variables, add DB_HOST, DB_PORT, DB_NAME, DB_USER and DB_PASSWORD from your database provider. If the provider supplies a CA certificate, add its full PEM text as DB_SSL_CA. Never commit credentials to GitHub.
4. Add variables to Production and Preview if you want both deployments to work. Use a separate database for preview when real users begin using the site.
5. Replace the repository website files with this folder's contents, including the dotfiles. Remove the old root login.php, inscription.php, Dashboard.php, logout.php and contact.php; those files now live in pages/.
6. In Vercel, choose Framework Preset Other. Disable old npm Build/Install overrides and any old Output Directory override. The vercel.json configuration sets these for this project.
7. Commit and push to the connected GitHub repository, then check Vercel's deployment status. Alternatively run `vercel` inside this folder for a preview and `vercel --prod` after verification.

## Verification

After deployment, open the homepage, register a test account, log in, refresh the dashboard, log out, and submit a test contact message. Confirm that the message appears in the contact table and a logged-out visitor cannot access the dashboard.

Google login and registration use a shared server-side authorization code flow with PKCE and a ten-minute, single-use session state. Google identity is retrieved from its UserInfo endpoint over verified TLS. Password accounts must sign in first and use **Associer mon compte Google** on the dashboard to link the same email. Google-only accounts receive a random, unknown password hash; no Google passwords or tokens are stored.

## Enable Google sign-in

1. Run `database/google-oauth.sql` against the existing database. New databases can use the updated `database/schema.sql` instead.
2. In Google Cloud Console, configure Google Auth Platform branding, audience and consent for this website. During testing, add the Google accounts that will test sign-in as test users.
3. Create an OAuth client with application type **Web application**. Add this exact authorized redirect URI: `https://babaali-tawjih.vercel.app/google-callback.php`. A different domain needs its own matching registered URI.
4. Add `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` and `GOOGLE_REDIRECT_URI` to Vercel environment variables. Set the redirect variable to the exact URI above. Keep the secret out of source control. Redeploy after changing variables.
5. Enable the PHP cURL extension if using another PHP host. For local testing, register `http://localhost:8000/google-callback.php` and set the redirect variable accordingly. Use a stable registered domain for previews.
6. Test Google registration, repeat login, consent cancellation, logout, and linking an existing password account. Missing configuration shows a friendly message while email/password authentication remains available.

Google setup reference: [Google OpenID Connect server flow](https://developers.google.com/identity/openid-connect/openid-connect).

## Personal dashboard and saved schools

Personal storage initializes missing `user_favorites` and `user_avatars` tables automatically on first authenticated use. Existing rows are preserved; connection errors do not trigger migrations. The database account needs CREATE permission for this initialization. If it has restricted permissions, run `database/personal-dashboard.sql` once with a database administrator account. New databases use `database/schema.sql`. Deploy the PHP routes, scripts, stylesheets, `data/` and `img/schools/` together.

The public directory and dashboard share the 72 existing schools in `data/schools.json`, with sector information in `data/sectors.json`. Keep school IDs stable when updating the catalog: favorites reference those IDs. Signed-in users can save schools in the directory, search/remove them in their dashboard, and update their name, phone and photo. The login email is read-only. Favorites and photos are stored in MySQL per user, so they persist across sessions and devices. No application tracking, deadline or notification placeholders are included.

Photos accept JPEG, PNG or WebP up to 1 MiB and 4096 pixels per side (12 million pixels total). They are stored as database blobs rather than Vercel filesystem uploads; the private avatar route serves only the current user's photo. Initials appear until a photo is saved. PHP requires `fileinfo` and `mbstring` as well as PDO MySQL. Google linking is shown in the dashboard only when its environment variables are configured.

Validation: `php tests/personal.php` uses an ephemeral SQLite database with MySQL upsert syntax translated for the test driver. It checks idempotent saves, isolation between accounts, CSRF validation, profile persistence, photo validation/replacement/removal, and transaction rollback. The live MySQL migration and browser upload flow still need deployment verification: use two accounts, save the same school in each, remove it from one account, update a photo, log out and back in, and confirm the other account's data is unaffected.

`node --test tests/dashboard-ui.cjs` checks directory rendering/filtering and the favorite client flow, including signed-out/error states and concurrent saves. `php tests/render-dashboard.php` creates synthetic empty/populated previews under `tests/`; these previews are excluded from deployment. The previews were checked in a browser at desktop and mobile widths, in light and dark themes, including saved-school search.

No package.json or npm build is needed. Do not publish a static-only copy of the PHP files.

Status: Published at https://babaali-tawjih.vercel.app/ on 8 October 2026. PHP syntax, homepage assets, registration, login, persistent sessions, logout, contact submission, and blocking of private source paths passed checks. Public homepage, login, and registration pages were checked without Vercel authentication.

The GitHub repository has not yet been updated. Commit this prepared copy before making another GitHub-triggered deployment. Otherwise the repository's old version may replace the tested deployment.

## Session-aware navigation and shared school cards

`AuthNavigation.js` reads the private `auth-status.php` endpoint. Login/signup appear only for signed-out visitors; Mon espace/logout appear only for signed-in users, including after navigating back from logout. Both the directory and dashboard use `Schools.js` for campus photographs, filters and expandable detail cards. Removing a saved school updates the dashboard list immediately after the database confirms the change. Official website links are labelled accurately; a Drive label appears only for an actual Drive URL.

School photos are local optimized WebP files, with image paths, descriptive alt text, campus captions and source links in `data/schools.json`. `img/schools/sources.json` records original photo URLs. Programs at the same campus share its photograph. ISPITS, BTS and CPGE identify their representative school in the caption. ERSSM uses a photograph of its officer training because an identifiable campus photograph could not be verified. Failed school images show the institution name instead of substituting an unrelated stock photo. Sector header illustrations remain separate from school photos.

## Activate password recovery

Run `database/password-recovery.sql` once in the hosted database. Add `RESEND_API_KEY`, `RECOVERY_EMAIL_FROM` (a sender on a verified Resend domain) and `SITE_URL=https://babaali-tawjih.vercel.app` in Vercel, then redeploy. The integration follows [Resend's send-email API](https://resend.com/docs/api-reference/emails/send-email). The application never logs raw reset tokens or provider keys.

Reset links expire after 30 minutes and can be used once. Only token hashes are stored. Reset requests are throttled by email and client IP; known and unknown email addresses receive the same response. Successful resets invalidate previous authenticated sessions for that account. The reset URL is cleared from the browser address before showing the password form. Without the email configuration or migration, recovery displays an availability message; live delivery must be checked with the configured provider.
