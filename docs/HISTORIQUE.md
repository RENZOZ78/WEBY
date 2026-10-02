# Historique du projet WebyCloudy

Journal de tout ce qui a été fait sur le site, **le plus récent en haut**.
À lire avant chaque tâche ; à compléter après chaque tâche (voir [`CLAUDE.md`](../CLAUDE.md)).

## Format d'une entrée

```markdown
## AAAA-MM-JJ — Titre court de la tâche

**Demande** : ce qui a été demandé, en une ou deux phrases.

**Réalisé** :
- ce qui a été fait, et pourquoi quand ce n'est pas évident

**Fichiers / zones touchés** : chemins principaux, ou « Hostinger : … »
**Vérifications** : tests faits et résultat
**Référence** : PR #… / commit …
**Suites** : ce qui reste à faire ou à valider (à reporter aussi dans « Points en suspens »)
```

Ne jamais écrire de mot de passe ni de clé dans ce fichier.

---

## Points en suspens

À mettre à jour à chaque entrée : ajouter ce qui reste, retirer ce qui est réglé.

- [ ] **Compléter le tableau « Hors site »** de `docs/CONTEXTE_ACTIF.md` (SEO, Instagram, Leboncoin, acquisition).
- [ ] **Changer les mots de passe** communiqués pendant la mise en ligne du 2026-10-02 : compte super-admin du site
      (`admin`, depuis *Mon profil*) et utilisateur MySQL `u181593296_weby` (hPanel, puis reporter le nouveau mot de
      passe dans `config/config.local.php` sur le serveur).
- [ ] **Tester l'envoi des mails** en production : formulaire de contact, création de compte (mail de validation),
      réponse de l'agence à une demande. Expéditeur : `info@webycloudy.com`.
- [ ] **Valider les tarifs indicatifs** ajoutés faute d'information dans le brief : forfait mensuel de gestion,
      facturation, image de marque (« sur devis »), acquisition clients (300 €/mois), site + blog (450 €),
      e-commerce (700 €). Fichiers `inc/content_*.php`.
- [ ] **Chiffres de la maquette du hero** (+38 %, +120 prospects, × 2,4) : illustratifs, à remplacer par des
      chiffres réels ou à retirer (`inc/header.php`).
- [ ] **Photos réelles** de l'équipe ou des locaux à intégrer à la place des photos de stock si disponibles.
- [ ] **Anciennes copies du site** sur `webycloudy.fr` et `webycloudy.xyz` (hébergement Hostinger) : ancienne
      version PHP avec le dossier `.idea`, domaines qui ne pointent pas vers Hostinger. À supprimer ou à rediriger.
- [ ] **Dossier `backup_v1`** (ancien site statique, à côté de `public_html`) : à supprimer quand la V2 est validée.
- [ ] Fichiers inutiles servis en production : `.idea/`, `.vscode/`, `node_modules/` sont encore suivis par git et
      donc déployés. Les retirer du dépôt (`git rm --cached`) en prévenant le propriétaire.
- [ ] **Charte graphique** (`docs/CHARTE_GRAPHIQUE.md`) : définir le logo sur fond clair et en monochrome,
      exporter le logo en PNG, valider la version claire pour les documents imprimés.

---

## 2026-10-02 — Charte graphique extraite du site

**Demande** : extraire la charte graphique (kit de marque) du site et l'ajouter au dépôt en bonne et due forme.

**Réalisé** :
- `docs/CHARTE_GRAPHIQUE.md` : logo, couleurs (bleu nuit, or, accents cyan / violet / rose), dégradés,
  typographies (Poppins, Inter), arrondis, ombres, composants, règles pour Instagram, Leboncoin et documents.
  Valeurs relevées dans `public/CSS/theme.css` et `inc/header.php` ; rien n'a été inventé ni modifié sur le site.
- Rédigé depuis Chat, qui n'a pas le droit d'écriture sur le dépôt : fichier remis au propriétaire, puis ajouté
  au dépôt par Claude Code avec cette entrée.

**Fichiers / zones touchés** : `docs/CHARTE_GRAPHIQUE.md`, `docs/CONTEXTE_ACTIF.md`, `README.md`
**Vérifications** : chaque valeur comparée aux variables `--wc-*` du thème en ligne ; documentation seule.
**Référence** : PR « Charte graphique »
**Suites** : version du logo sur fond clair et monochrome ; couleurs exactes de l'emblème ; exports PNG du logo ;
version claire pour les documents imprimés à valider.

---

## 2026-10-02 — Suivi partagé entre Claude Code, Cowork et Chat

**Demande** : que les projets Cowork et Chat de WebyCloudy prennent connaissance de ce qui a été fait et des
avancées, et que chaque avancée soit enregistrée dans les fichiers `.md` du dépôt (structure du même type que
celle de Sportmaniax).

**Réalisé** :
- `docs/CONTEXTE_ACTIF.md` : état du projet sur une page (situation, 3 priorités, hors site, sujets ouverts,
  rôle de chaque outil). Il sert aussi de tableau de bord : pas de fichier séparé, pour éviter les doublons.
- `docs/DECISIONS.md` : choix durables en vigueur, reconstitués depuis l'historique.
- `CLAUDE.md` : ordre de lecture et règles d'enregistrement étendus à Cowork et Chat, et au travail hors code.
- `README.md` : liens vers les deux nouveaux documents.

**Fichiers / zones touchés** : `docs/CONTEXTE_ACTIF.md`, `docs/DECISIONS.md`, `CLAUDE.md`, `README.md`
**Vérifications** : relecture ; aucun secret ; documentation seule, aucun fichier du site modifié.
**Référence** : PR « Suivi partagé » (réalisé depuis Cowork)
**Suites** : compléter le tableau « Hors site » du contexte actif ; coller la consigne de lecture dans les
instructions des projets Cowork et Chat.

---

## 2026-10-02 — Mise en place du journal et des consignes

**Demande** : enregistrer ce qui a été fait dans des fichiers `.md` sur GitHub, avec pour consigne de lire
l'historique avant chaque tâche et d'enregistrer chaque tâche réalisée.

**Réalisé** :
- `CLAUDE.md` à la racine : consignes lues automatiquement en début de session (lire l'historique avant d'agir,
  consigner chaque tâche, règles du projet).
- `docs/HISTORIQUE.md` (ce fichier) : journal reconstitué depuis l'audit initial, points en suspens.
- `docs/DEPLOIEMENT.md` : description de la production (Hostinger, base, déploiement Git, configuration, retour arrière).
- Lien vers ces documents ajouté dans le `README.md`.

**Fichiers / zones touchés** : `CLAUDE.md`, `docs/HISTORIQUE.md`, `docs/DEPLOIEMENT.md`, `README.md`
**Vérifications** : relecture ; aucun secret dans les fichiers ; les `.md` ne sont pas servis par le site
(`.htaccess` renvoie 403 sur `*.md`).
**Référence** : PR #5
**Suites** : —

---

## 2026-10-02 — Titre animé illisible sur mobile, téléphone et adresse pro

**Demande** : le titre de l'accueil est illisible sur mobile (capture fournie) ; afficher le numéro pro
06 52 47 37 99 ; utiliser une adresse professionnelle @webycloudy.com existante dans Hostinger.

**Réalisé** :
- Titre « Lancez et développez votre … » : le dégradé doré était appliqué au conteneur des mots qui tournent ;
  sur mobile le navigateur peignait le texte de tous les mots, même masqués, d'où une superposition illisible.
  Le dégradé est maintenant appliqué à chaque mot, les mots masqués sont en `visibility: hidden`, et l'ancien mot
  disparaît avant que le suivant n'apparaisse (`public/CSS/theme.css`, `public/Javascript/main.js`, `inc/header.php`).
- Téléphone : 06 52 47 37 99 (`config/config.php`).
- Deux boîtes existent sur le domaine (Hostinger Business Email) : `contact@` (quasi inutilisée) et `info@`
  (utilisée, avec redirections). Choix : **info@webycloudy.com**, affichée sur le site, destinataire des
  notifications, et expéditeur des mails du site (`From` + enveloppe `-f`, cohérent avec le SPF du domaine).

**Fichiers / zones touchés** : `public/CSS/theme.css`, `public/Javascript/main.js`, `inc/header.php`,
`config/config.php`, `config/config.local.example.php`, `controllers/Toolbox.class.php`
**Vérifications** : animation échantillonnée toutes les 50 ms pendant 12 s (mobile 412 px et ordinateur) :
jamais plus d'un mot visible ; numéro et adresse présents sur accueil, contact, prestations ; fichiers vérifiés
sur le serveur après déploiement.
**Référence** : PR #4 (commit `294f888`, fusion `ec60b41`)
**Suites** : tester l'envoi des mails en production.

---

## 2026-10-02 — Mise en ligne de la V2 sur webycloudy.com

**Demande** : mettre le nouveau site en ligne (feu vert du propriétaire), en faisant les 4 étapes :
base de données, sauvegarde de l'ancien site, déploiement, configuration.

**Réalisé** (détails dans [`DEPLOIEMENT.md`](DEPLOIEMENT.md)) :
- PHP du site passé de 7.4 à **8.4**.
- Base MySQL créée : `u181593296_webycloudy`, utilisateur `u181593296_weby`.
- Ancien site statique (V1) déplacé dans `domains/webycloudy.com/backup_v1` ; `public_html` recréé vide.
- Déploiement Git Hostinger configuré : dépôt `RENZOZ78/WEBY`, branche **`V2`**, racine de `public_html`,
  déploiement automatique à chaque fusion.
- `config/config.local.php` écrit sur le serveur (identifiants base + compte super-admin initial `admin`).
- Installation automatique exécutée : tables créées, compte super-admin créé, marqueur `storage/.installed` présent.
- Tâches cron temporaires utilisées pour les opérations serveur, toutes supprimées ensuite.

**Fichiers / zones touchés** : Hostinger (site webycloudy.com, base MySQL, déploiement Git, PHP)
**Vérifications** : contenu de `public_html` et de `storage/` vérifié par l'API Hostinger ; liste des crons vide.
**Référence** : PR #2 et #3 fusionnées dans `V2`
**Suites** : changer les mots de passe ; tester les mails ; supprimer `backup_v1` une fois la V2 validée.

---

## 2026-10-02 — Corrections de revue et installation automatique

**Demande** : traiter la revue automatique de la PR #2 avant la mise en ligne.

**Réalisé** :
- `storage/` ajouté aux chemins interdits du `.htaccess` (la règle ne le couvrait pas : un document client
  aurait pu être téléchargé sans connexion en connaissant son nom), plus `storage/.htaccess` qui refuse tout.
- Suppression de compte : projets, documents (fichiers inclus), demandes et messages du client supprimés dans
  une transaction, pour qu'un futur compte portant le même login n'hérite de rien.
- Installation automatique au premier lancement (`models/Installation.class.php`) : création des tables depuis
  `database.sql` et du compte super-admin défini dans `config/config.local.php`. Elle n'interrompt pas le site
  tant que la base n'est pas configurée (PR #3).
- `config/config.local.php` (non versionné) surcharge `config/config.php` ; modèle dans `config.local.example.php`.

**Référence** : commit `abb37af` (PR #2), PR #3

---

## 2026-10-01 — Images et animations

**Demande** : mettre des images et des animations professionnelles.

**Réalisé** :
- Les banques d'images et Canva étaient inaccessibles depuis l'environnement de travail : utilisation des photos
  déjà présentes dans le projet (`public/Assets/images/`, `img/`), choisies et cadrées.
- Hero : photo d'équipe, maquette de tableau de bord animée, halos de couleur, mot qui tourne, parallaxe ;
  bandeau défilant des prestations ; section « Secteurs » ; packs sur photo de fond ; cartes inclinables 3D ;
  compteurs animés ; trait des étapes ; bordure animée de l'offre vedette ; barre de progression de lecture ;
  connexion et inscription avec photo. Animations désactivées si l'utilisateur préfère les mouvements réduits.

**Référence** : commit `4175990` (PR #2)

---

## 2026-10-01 — Espace client, design sombre et nouvelles prestations

**Demande** : un espace client utile, un design sombre et coloré « pro qui donne envie », et les nouvelles
prestations fournies par le propriétaire (Pack Lancement & Financement, Pack Croissance).

**Réalisé** :
- **Espace client** (`compte/…`) : tableau de bord, suivi des projets par étapes (devis → en cours → validation →
  livré) avec message de l'agence, documents téléchargeables, demandes avec fil de messages.
- **Administration** (`administration/…`) : tableau de bord, demandes (le formulaire de contact crée une demande
  en base), réponse par mail et dans l'espace, projets par client, dépôt de documents, clients et droits.
- Nouvelles tables `projets`, `documents`, `demandes`, `messages` ; tables `produits` / `commandes` abandonnées.
  Documents stockés dans `storage/documents/` (hors web), servis après contrôle du propriétaire.
- **Design** sombre (bleu nuit, or du logo, cyan, violet), Bootstrap 5.3 en `data-bs-theme="dark"`.
- **Prestations** : business plan dès 299 € (prévisionnel seul 150 €), création de société dès 200 € + frais,
  gestion & administratif (RH dès 30 €), site internet dès 300 €, marketing & croissance dès 500 €.
  Nouvelles pages `prestations/lancement` et `prestations/gestion` ; anciennes adresses redirigées en 301.

**Référence** : commit `9a41745` (PR #2)
**Suites** : tarifs indicatifs à valider (voir « Points en suspens »).

---

## 2026-10-01 — Corrections de l'audit et première refonte

**Demande** : corriger toutes les erreurs de l'audit et améliorer le design.

**Réalisé** :
- Sécurité : suppression de l'affichage du hash du mot de passe à la connexion ; jeton CSRF sur tous les POST ;
  rôles vérifiés côté serveur (un admin ne peut plus se promouvoir) ; clé de validation non devinable ;
  session régénérée à la connexion ; cookie `httponly` / `SameSite=Lax` ; `.htaccess` bloquant le code.
- Bugs : super-admin qui écrasait le rôle avec le mail, page commandes vide, redirections `Location :`
  invalides, liens morts, page d'erreur sans message, formulaire de contact non traité, warnings PHP 8.4.
- Bootstrap 5.3 unifié, Font Awesome 6 gratuit, fichiers morts supprimés, `database.sql`, `README.md`, `.gitignore`.
- Contenu : faux logos clients (Spotify, Apple…) et galerie Unsplash factice retirés, remplacés par les vraies
  réalisations (Fiteos, Delta-Immo, Magic Food Panam, Dofinvest).

**Référence** : commit `d0d6131` (PR #2)

---

## 2026-09-30 — Audit initial

**Demande** : faire un audit de ce qui fonctionne ou non dans le projet.

**Constat** (site testé en local, PHP 8.4 + MariaDB) : pages publiques et gestion de compte de base
fonctionnelles ; super-admin qui corrompait la base ; page commandes vide ; redirections cassées ; hash du mot de
passe renvoyé au navigateur ; élévation de droits possible ; pas de CSRF ; clé de validation sur 4 chiffres ;
identifiants de base en dur ; pas de dump SQL ; Bootstrap 4 et 5 mélangés ; fichiers inutiles dans le dépôt.
Le site en ligne sur webycloudy.com était alors l'ancien site statique (V1), la V2 n'était pas déployée.
