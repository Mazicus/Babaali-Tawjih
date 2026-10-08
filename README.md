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

The Google sign-in buttons in the original project are placeholders. Google authentication still requires a separate implementation. The dashboard retains the original content and behavior.

No package.json or npm build is needed. Do not publish a static-only copy of the PHP files.

Status: Published at https://babaali-tawjih.vercel.app/ on 8 October 2026. PHP syntax, homepage assets, registration, login, persistent sessions, logout, contact submission, and blocking of private source paths passed checks. Public homepage, login, and registration pages were checked without Vercel authentication.

The GitHub repository has not yet been updated. Commit this prepared copy before making another GitHub-triggered deployment. Otherwise the repository's old version may replace the tested deployment.
