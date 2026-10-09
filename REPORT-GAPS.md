# Implemented scope and remaining report gaps

The backend now uses Laravel 13, Blade views, Eloquent models, native authentication, database sessions, CSRF protection and additive migrations. Existing page layouts and public `.php` addresses are preserved. The standalone PHP implementation is no longer active.

Implemented: registration and password login, per-account school favorites, editable name and phone, uploaded profile photos with initials fallback, private photo retrieval, contact submission, Google OAuth with PKCE and explicit account linking, Resend-backed password recovery and invalidation of older sessions after a reset.

The catalogue remains in shared JSON files, with real institution photographs and source metadata. Administration of schools, training programmes and users, application tracking, calendars, personalised follow-up and notifications remain outside the implemented scope.

The historical users and contact columns are preserved for compatibility. Laravel adds technical session, cache and reset-token tables. These technical tables are not new business entities for the report's conceptual model. Existing account data is retained by the adoption migration; prior sessions and old reset links require a fresh login or recovery request.

The Laravel migration was verified locally using an isolated SQLite database and automated PHP/JavaScript tests. Previously recorded production checks concerned the earlier PHP deployment and do not verify the Laravel version. Production deployment, hosted MySQL migration, real Google sign-in and actual email delivery still require configuration and verification.

Vercel uses a community PHP runtime; TiDB Cloud is MySQL-compatible hosting rather than the local MySQL server described in the original XAMPP setup. Laravel requires PHP 8.3+, so PHP 8.0 cannot remain the application runtime.

`RAPPORT-LARAVEL.md` contains French replacement material and the sections to revise. The original `RAPPORT_STAGE_IAGI_PROTOTYPE.docx` was referenced in earlier work but is not available in this workspace and was not modified here.
