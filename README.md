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

No package.json or npm build is needed. Do not publish a static-only copy of the PHP files.

Status: Published at https://babaali-tawjih.vercel.app/ on 8 October 2026. PHP syntax, homepage assets, registration, login, persistent sessions, logout, contact submission, and blocking of private source paths passed checks. Public homepage, login, and registration pages were checked without Vercel authentication.

The GitHub repository has not yet been updated. Commit this prepared copy before making another GitHub-triggered deployment. Otherwise the repository's old version may replace the tested deployment.
