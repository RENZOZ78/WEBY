# WebyCloudy — consignes de travail

Ce fichier est lu automatiquement au début de chaque session (Claude Code et assistants compatibles).
Il s'applique à **toute personne ou tout agent** qui travaille sur ce dépôt.

## 1. Avant toute tâche : prendre connaissance de l'historique

Avant de modifier quoi que ce soit, lire dans cet ordre :

1. [`docs/HISTORIQUE.md`](docs/HISTORIQUE.md) — au minimum les **5 dernières entrées** et la section
   « Points en suspens ». Elles disent ce qui a déjà été fait, pourquoi, et ce qui reste à valider.
2. [`docs/DEPLOIEMENT.md`](docs/DEPLOIEMENT.md) — dès que la tâche touche la mise en ligne, la base de données,
   la configuration, Hostinger ou le nom de domaine.
3. [`README.md`](README.md) — architecture du code, installation locale, rôles.

Ne pas refaire ni annuler un choix consigné dans l'historique sans en avoir parlé au propriétaire du site.

## 2. Après chaque tâche réalisée : l'enregistrer

Chaque tâche terminée (code, contenu, configuration, intervention sur Hostinger, décision importante) est
consignée **dans le même commit ou la même PR que le travail** :

- **Toujours** : ajouter une entrée **en haut** de [`docs/HISTORIQUE.md`](docs/HISTORIQUE.md), au format décrit
  dans ce fichier (date, demande, ce qui a été fait, fichiers, vérifications, PR / commit, suites).
- **Si la production change** (base, fichiers sur le serveur, configuration, branche déployée, domaine, mails,
  PHP, sauvegardes) : mettre aussi à jour [`docs/DEPLOIEMENT.md`](docs/DEPLOIEMENT.md).
- **Si l'architecture, l'installation locale ou les rôles changent** : mettre à jour [`README.md`](README.md).
- Mettre à jour la section « Points en suspens » de l'historique : ajouter ce qui reste à faire,
  retirer ce qui a été réglé.

Une tâche n'est pas terminée tant que l'historique n'est pas à jour.

## 3. Règles du projet

- **Jamais de secret dans le dépôt** (mots de passe, clés, jetons) : ni dans le code, ni dans les `.md`.
  Les identifiants de production vivent uniquement dans `config/config.local.php` sur le serveur
  (fichier ignoré par git). Dans la documentation, écrire « voir hPanel » ou « voir config.local.php ».
- **La branche `V2` est la production** : toute fusion dans `V2` est déployée automatiquement sur
  https://webycloudy.com (déploiement Git Hostinger). Travailler sur une branche dédiée, ouvrir une PR vers `V2`,
  tester avant de fusionner. La branche `master` contient l'ancien site statique (V1).
- **Tester avant de pousser** : `php -l` sur les fichiers PHP modifiés, parcours des pages concernées en local
  (PHP 8.4 + MySQL/MariaDB, voir README), aucun warning PHP, aucune erreur JavaScript, affichage mobile vérifié.
- Toutes les requêtes POST passent par le jeton CSRF (`Securite::csrfField()` dans chaque formulaire).
- Langue : le site, les messages de commit, les PR et la documentation sont **en français**.
- Le téléphone, l'adresse mail et les horaires affichés se modifient dans `config/config.php`.
