# Prototype scope compared with the internship report

Reference: RAPPORT_STAGE_IAGI_PROTOTYPE.docx, supplied by the user on 8 October 2026. The report was read, including the class, conceptual data and logical data diagrams. The user chose to publish the existing prototype and document gaps rather than implement all proposed features.

## Existing prototype

The website retains the original homepage, services, process, school search, contact section, registration and login pages, and personal dashboard appearance. Registration stores a full name, email, phone and hashed password. Login creates an authenticated session. Contact submissions are stored in a database.

These flows were verified on Vercel: account registration, password login, authenticated dashboard refresh, logout, and contact submission. Homepage assets and blocked private source paths were also checked. The public production link is https://babaali-tawjih.vercel.app/ and works without a Vercel account.

## Features described in the report that are incomplete

- Administration of establishments, courses and users has no implemented administration interface or role system.
- The report diagrams contain ECOLE, FORMATION and CANDIDATURE entities. The prototype uses a school catalogue embedded in JavaScript and does not persist courses or applications in these tables.
- Google registration and login buttons are placeholders. No Google OAuth integration is configured.
- The password recovery link has no recovery workflow or email delivery.
- Dashboard shortcuts, favourites, calendar and several statistics are static prototype elements. They do not represent a complete personalised service.
- Personalised follow-up and notifications mentioned in the registration description are not implemented.

## Differences in the implemented data model

The prototype's `users` table implements the report's UTILISATEUR concept using different field names: `id` maps to `id_user`, `full_name` to `nom`, `adress_email` to `email`, and `mot_de_passe` to `mot_de_passe`. The additional `phonenumber` field matches the registration form shown in the report.

The prototype's `contact` table uses `id`, `full_name`, `adresse_email` and `message_TEXT`; the report's CONTACT entity uses `id_contact`, `nom`, `email`, `message` and `date`. The current prototype does not record the date or an association with a logged-in user. The report itself differs between the class diagram (free contact form) and MCD (contact associated with a user). The existing public contact form is retained.

`site_sessions` is deployment infrastructure for persistent sessions on Vercel; it is not a business entity from the report.

## Hosting details

The original report describes PHP and MySQL developed locally using XAMPP. XAMPP remains a local development tool. The proposed hosted copy runs PHP through the community `vercel-php` runtime and stores data in TiDB Cloud, a MySQL-compatible database. TiDB is not the MySQL server product described in the report; this hosting difference must be stated accurately in any deployment section added to the report.

The TiDB Starter instance and three prototype tables were created. Its monthly spending limit was set to $0. No existing local users or messages were migrated. Verification created one synthetic test account and one test contact message, labelled "Verification de deploiement", using an example.invalid email address. The prototype was deployed and promoted to the public domain on 8 October 2026.

The deployment was made directly from the prepared files. The GitHub repository was not updated: the Git client could not access the private repository from this environment. Future GitHub-triggered deployments can replace this version until the prepared files are committed to the repository.

Do not describe the conceptual diagrams, prototype screens or future enhancements as proof that these missing features are functional.
