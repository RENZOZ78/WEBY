# WebyCloudy

Site vitrine et espace membre de l'agence WebyCloudy (PHP 8 / MySQL, architecture MVC maison, Bootstrap 5.3).

## Installation locale (XAMPP)

1. Copier le dossier dans `htdocs/` et activer `mod_rewrite` (le fichier `.htaccess` route toutes les URL vers `index.php`).
2. Créer la base : importer `database.sql` dans phpMyAdmin (ou `mysql -u root < database.sql`).
3. Les identifiants de base de données se règlent dans `config/config.php`, ou par variables d'environnement
   `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` (recommandé en production). Le téléphone, l'email de contact et
   les horaires affichés sur le site se modifient au même endroit.
4. Pour que les mails (validation de compte, formulaire de contact) partent, configurer `sendmail`/SMTP dans `php.ini`.

## Structure

- `index.php` : routeur (toutes les pages passent par lui)
- `controllers/`, `models/`, `views/` : MVC par rôle (Visiteur, Utilisateur, Administrateur, SuperAdministrateur)
- `inc/content_*.php` : contenu des pages publiques ; `inc/partials/` : sections réutilisables (tarifs, réalisations, contact…)
- `public/CSS/theme.css` : thème du site ; `public/Javascript/` : scripts

## Rôles

- **utilisateur** : profil, mail, mot de passe, photo, suppression du compte
- **administrateur** : consultation des utilisateurs, commandes, produits ; peut passer un utilisateur en administrateur
- **superAdministrateur** : gestion complète (mail, rôle, validation du compte) de tous les utilisateurs

Toutes les requêtes POST sont protégées par un jeton CSRF (`Securite::csrfField()` à inclure dans chaque formulaire).
