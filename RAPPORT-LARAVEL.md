# Mise à jour du rapport : adoption de Laravel

Ce document fournit les adaptations à intégrer au rapport de stage. Le fichier Word original n'a pas été modifié dans cette migration.

## Technologies et architecture

Le backend de Babaali Tawjih utilise désormais Laravel 13, un framework PHP organisé selon une architecture MVC. PHP reste le langage du serveur ; Laravel structure le routage, l'authentification, la validation, les sessions et l'accès aux données. PHP 8.3 ou supérieur est requis. L'ancienne installation locale de PHP 8.0 doit être remplacée ou complétée par un environnement compatible.

Les routes sont définies dans `routes/web.php`. Les contrôleurs traitent les demandes de connexion, d'inscription, de gestion du profil, de favoris, de contact, de connexion Google et de récupération du mot de passe. Les modèles Eloquent représentent les comptes, les favoris, les photos de profil, les associations Google et les messages de contact. Les vues Blade conservent les interfaces existantes ; les fichiers CSS, JavaScript, SVG et les photographies sont placés dans le dossier public.

## Données conservées

La migration conserve les tables métier existantes et leurs données. Les noms historiques des colonnes du compte, notamment `adress_email` et `mot_de_passe`, sont conservés pour assurer la compatibilité. Les mots de passe existants restent utilisables sans réinitialisation obligatoire. Les favoris sont associés à chaque utilisateur et les photos de profil sont enregistrées dans la base avec un accès réservé au propriétaire.

Des migrations Laravel ajoutent les infrastructures nécessaires aux sessions, au cache, aux jetons de réinitialisation et à la mémorisation de la connexion. Le catalogue des établissements reste un ensemble de fichiers JSON partagés entre la page d'accueil et le tableau de bord. Il ne constitue pas encore une administration des écoles et formations en base de données.

## Sécurité et fonctionnalités

Laravel assure la validation côté serveur, le hachage des nouveaux mots de passe, la protection CSRF des formulaires et la restriction des pages personnelles. Les favoris et photos sont isolés par compte. La déconnexion se fait par un formulaire POST protégé. Une réinitialisation de mot de passe invalide les sessions antérieures et utilise un jeton expirant après 30 minutes.

La connexion Google utilise OAuth 2.0 avec état de session et PKCE. L'association à un compte existant nécessite d'être déjà connecté à ce compte. L'envoi des messages de récupération utilise le transport Resend de Laravel. Leur activation en production dépend des identifiants externes et du domaine d'envoi configuré.

## Déploiement et validation

Le site est préparé pour Vercel avec le runtime communautaire PHP et une base MySQL compatible, notamment TiDB Cloud. Le point d'entrée public initialise Laravel. Les anciens chemins `.php` sont conservés pour les liens existants. Les répertoires privés de l'application ne sont pas exposés par les routes Vercel.

La migration a été vérifiée localement avec une base SQLite isolée, des tests Laravel et les tests JavaScript du catalogue. Ces vérifications ne constituent pas une validation du déploiement MySQL réel, de la connexion à un vrai compte Google ou de la réception d'un email réel. Ces validations doivent suivre la configuration des services et le déploiement.

## Parties du rapport à ajuster

- Présentation des outils : ajouter Laravel 13, Composer, Blade, Eloquent et Artisan.
- Architecture : présenter MVC et le rôle des routes, contrôleurs, modèles et vues.
- Réalisation : remplacer les descriptions de scripts PHP autonomes et de requêtes PDO par les traitements Laravel.
- Modèle de données : conserver les entités métier et distinguer les tables techniques du framework.
- Installation : préciser PHP 8.3 minimum, les variables d'environnement et les migrations.
- Tests : distinguer les validations locales automatisées des validations externes encore nécessaires.

Les objectifs du projet, son public, le contexte de l'orientation et les écrans existants restent pertinents. Le rapport ne doit pas annoncer de suivi des candidatures, de calendrier, de notifications ou d'administration des écoles : ces fonctions ne sont pas implémentées.
