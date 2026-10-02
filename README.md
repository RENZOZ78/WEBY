# WebyCloudy

Site vitrine et espace client de l'agence WebyCloudy (PHP 8 / MySQL, architecture MVC maison, Bootstrap 5.3, thème sombre).

## Installation locale (XAMPP)

1. Copier le dossier dans `htdocs/` et activer `mod_rewrite` (le fichier `.htaccess` route toutes les URL vers `index.php`).
2. Créer la base : importer `database.sql` dans phpMyAdmin (ou `mysql -u root < database.sql`).
3. Les identifiants de base de données se règlent dans `config/config.php`, ou par variables d'environnement
   `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` (recommandé en production). Le téléphone, l'email de contact et
   les horaires affichés sur le site se modifient au même endroit.
4. Pour que les mails (validation de compte, demandes, réponses de l'agence) partent, configurer `sendmail`/SMTP dans `php.ini`.
5. Le dossier `storage/documents/` doit être accessible en écriture par PHP : c'est là que sont rangés les documents
   déposés pour les clients. Il n'est jamais servi directement (bloqué par `.htaccess`) : les téléchargements passent par
   `compte/document/{id}` avec contrôle du propriétaire.

## Structure

- `index.php` : routeur (toutes les pages passent par lui)
- `controllers/`, `models/`, `views/` : MVC par rôle (Visiteur, Utilisateur, Administrateur, SuperAdministrateur)
- `inc/content_*.php` : contenu des pages publiques ; `inc/partials/` : sections réutilisables (tarifs, réalisations, contact…)
- `public/CSS/theme.css` : thème du site ; `public/Javascript/` : scripts
- `storage/documents/` : fichiers des clients (hors dépôt git)

## Espace client

- **Client** (`compte/...`) : tableau de bord, suivi de l'avancement de ses projets (devis → en cours → validation → livré),
  téléchargement de ses documents, demandes avec fil de messages, profil.
- **Administration** (`administration/...`) : tableau de bord, demandes (formulaire de contact + demandes des clients,
  réponse par mail et dans l'espace, statut), projets (création pour un client, étape, message visible, dépôt de documents),
  clients et droits.
- Le formulaire de contact public crée une demande : rien ne se perd si le mail ne part pas.

## Rôles

- **utilisateur** (client) : espace client complet, profil, mail, mot de passe, photo, suppression du compte
- **administrateur** : demandes, projets, documents, clients ; peut passer un utilisateur en administrateur
- **superAdministrateur** : gestion complète (mail, rôle, validation du compte) de tous les utilisateurs

Toutes les requêtes POST sont protégées par un jeton CSRF (`Securite::csrfField()` à inclure dans chaque formulaire).
