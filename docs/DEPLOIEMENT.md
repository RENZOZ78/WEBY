# Production — webycloudy.com

État de la production et marche à suivre pour la faire évoluer.
**À mettre à jour à chaque changement côté serveur** (voir [`CLAUDE.md`](../CLAUDE.md)).
Aucun mot de passe ici : ils sont dans hPanel et dans `config/config.local.php` sur le serveur.

Dernière mise à jour : 2026-10-03

## Vue d'ensemble

| Élément | Valeur |
|---|---|
| Site | https://webycloudy.com (`www` redirige vers le domaine) |
| Hébergeur | Hostinger, offre Cloud Startup, compte `u181593296` |
| Dossier du site | `/home/u181593296/domains/webycloudy.com/public_html` |
| PHP | 8.4 (passé de 7.4 le 2026-10-02) |
| Base de données | MySQL `u181593296_webycloudy`, utilisateur `u181593296_weby`, hôte `127.0.0.1` |
| Code déployé | dépôt GitHub `RENZOZ78/WEBY`, branche **`V2`** |
| Mails | Hostinger Business Email ; adresse du site : `info@webycloudy.com` (existe aussi : `contact@`) |
| SSL | certificat Hostinger à vie, redirection HTTPS active |
| Domaine | `webycloudy.com` chez Hostinger, verrouillé, protection WHOIS, renouvellement automatique |

## Déploiement

Le déploiement Git automatique de Hostinger est actif sur la branche `V2` :
**toute fusion dans `V2` est mise en ligne automatiquement** (en général en moins d'une minute).

Si un déploiement ne part pas, le relancer en ré-enregistrant les réglages dans hPanel
(*Sites → webycloudy.com → Avancé → Git*), ou par l'API Hostinger
(`hosting_git_update-auto-deployment-settings`, mêmes valeurs) : l'enregistrement déploie immédiatement.

**Attention** : entre le 2026-10-02 (PR #4) et le 2026-10-03, aucune fusion n'a été déployée sans que rien ne le
signale (PR #5 à #10 absentes du serveur). Après chaque fusion, **vérifier que la production a bien changé** :
par l'API de fichiers Hostinger (`hosting_files_website-content` / `hosting_files_list-website-and-directories`),
comparer un fichier modifié avec `V2` ; ou dans le navigateur, regarder le code source de la page. Sinon, relancer
le déploiement comme ci-dessus. Dernier déploiement contrôlé : commit `10c73a6` (PR #10), le 2026-10-03.

Réglages en place (vérifiés le 2026-10-03) : installation GitHub `RENZOZ78` active, dépôt `RENZOZ78/WEBY`,
branche `V2`, déploiement à la racine du site (`public_html`), déploiement automatique activé.

Fichiers présents sur le serveur mais **absents du dépôt** (le déploiement ne les écrase pas) :
- `config/config.local.php` : identifiants de la base, adresse de contact, compte super-admin initial.
  Modèle : `config/config.local.example.php`.
- `storage/.installed` : marqueur de fin d'installation. Le supprimer relance l'installation au chargement
  suivant (tables créées si absentes, compte super-admin créé s'il n'en existe aucun).
- `storage/.schema` : version du schéma installée (2 depuis la supervision). Quand le code porte une version
  plus récente (`Installation::VERSION`), les nouvelles tables de `database.sql` sont créées automatiquement au
  premier chargement qui suit le déploiement, sans toucher aux données existantes.
- `storage/.sel` : sel secret de la mesure d'audience (empreinte anonyme des visiteurs), créé automatiquement.
- `storage/documents/` : documents déposés pour les clients.

## Base de données

Tables : `utilisateur`, `projets`, `documents`, `demandes`, `messages`, et depuis la supervision (version 2 du
schéma) `visites` (mesure d'audience, sans IP), `journal` (journal d'activité, IP tronquée) et `preferences`
(tableau de bord personnalisé). Visites et journal sont purgés automatiquement au-delà de 400 jours.

## Configuration

- `config/config.php` (versionné) : valeurs par défaut, téléphone, adresse mail, horaires affichés.
- `config/config.local.php` (serveur uniquement) : surcharge `config.php` (base de données, comptes).
- Pour changer le mot de passe MySQL : le modifier dans hPanel (*Bases de données MySQL*), puis reporter le
  nouveau mot de passe dans `config/config.local.php` via le gestionnaire de fichiers.

## Sauvegarde et retour arrière

- Ancien site statique (V1) : `domains/webycloudy.com/backup_v1` (à côté de `public_html`), et branche `master`
  du dépôt.
- Revenir à la V1 : vider `public_html`, y remettre le contenu de `backup_v1`, et désactiver le déploiement Git.
- Revenir à une version précédente de la V2 : faire un « revert » de la PR concernée dans `V2` (redéploiement auto).
- La base de données n'est pas sauvegardée par le dépôt : utiliser les sauvegardes Hostinger (hPanel).

## Intervenir sur le serveur sans accès SSH

Utilisé pour la mise en ligne du 2026-10-02 (outils API Hostinger) :
- L'API de fichiers sait lister et lire des fichiers texte, mais refuse les fichiers contenant des secrets
  (`config/*.php`) et ne sait pas écrire directement.
- Pour une commande serveur : créer une tâche cron (`* * * * *`) via l'API, lire sa sortie
  (`hosting_cron-jobs_output`) après une à deux minutes, puis **la supprimer**.
  Limites : 255 caractères par commande (après échappement) ; préférer des chemins absolus
  (`$HOME/domains/...`) ; écrire un long fichier en plusieurs crons avec `file_put_contents(..., FILE_APPEND)`.
- Vérifier à la fin que la liste des crons est vide.

## Autres domaines et sites du compte (pour mémoire)

- `webycloudy.fr` et `webycloudy.xyz` : hébergements contenant une ancienne version PHP du site (avec `.idea`).
  Ces domaines ne pointent pas vers Hostinger : sites inaccessibles. À nettoyer.
- `fiteos.click`, `dofinvest.fr`, `dofinivest.com`, `okago.click`, `transport-deluxe.fr`, `lapasserelle.click`,
  `reno-construction.click`, `sportmaniax.com` : autres sites du compte, non concernés par ce dépôt.
