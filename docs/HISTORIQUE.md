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

- [ ] **Supervision** (PR de l'entrée du 2026-10-03) : après fusion, vérifier que le serveur a reçu la version, que
      `storage/.schema` contient `2` et que les tables `visites`, `journal`, `preferences` existent ; se connecter avec le
      compte super-admin et parcourir *Supervision*. Ajouter `?utm_source=instagram` / `?utm_source=leboncoin` aux liens
      publiés pour suivre ces sources. Décider si des administrateurs doivent avoir un accès partiel à la supervision.
- [ ] **Compléter le tableau « Hors site »** de `docs/CONTEXTE_ACTIF.md` (SEO, Instagram, Leboncoin, acquisition).
- [ ] **Changer les mots de passe** communiqués pendant la mise en ligne du 2026-10-02 : compte super-admin du site
      (`admin`, depuis *Mon profil*) et utilisateur MySQL `u181593296_weby` (hPanel, puis reporter le nouveau mot de
      passe dans `config/config.local.php` sur le serveur).
- [ ] **Tester l'envoi des mails** en production : formulaire de contact, création de compte (mail de validation),
      réponse de l'agence à une demande. Expéditeur : `info@webycloudy.com`.
- [ ] **Valider les tarifs indicatifs** ajoutés faute d'information dans le brief : forfait mensuel de gestion,
      facturation, image de marque (« sur devis »), acquisition clients (300 €/mois), site + blog (450 €),
      e-commerce (700 €). Fichiers `inc/content_*.php`.
- [ ] **Cycle animé du hero de l'accueil** (`inc/partials/cycle.php`) : réellement en ligne depuis le redéploiement
      du 2026-10-03 au soir (PR #9 et #10). Contrôler le rendu sur le site en ligne, sur téléphone et sur
      ordinateur, avec la police Poppins.
- [ ] **Déploiement automatique Hostinger** : il ne s'est plus déclenché entre la PR #4 et le 2026-10-03 (relancé à la
      main). Après chaque fusion dans `V2`, vérifier que le serveur a reçu la nouvelle version ; chercher la cause
      (webhook GitHub de l'installation Hostinger, à voir dans hPanel *Sites → webycloudy.com → Avancé → Git*).
- [ ] **Photos réelles** de l'équipe ou des locaux à intégrer à la place des photos de stock si disponibles.
- [ ] **Anciennes copies du site** sur `webycloudy.fr` et `webycloudy.xyz` (hébergement Hostinger) : ancienne
      version PHP avec le dossier `.idea`, domaines qui ne pointent pas vers Hostinger. À supprimer ou à rediriger.
- [ ] **Dossier `backup_v1`** (ancien site statique, à côté de `public_html`) : à supprimer quand la V2 est validée.
- [ ] Fichiers inutiles servis en production : `.idea/`, `.vscode/`, `node_modules/` sont encore suivis par git et
      donc déployés. Les retirer du dépôt (`git rm --cached`) en prévenant le propriétaire.
- [ ] **Charte graphique** (`docs/CHARTE_GRAPHIQUE.md`) : créer un fichier de l'aigle seul (le logo actuel
      contient le nom), trancher l'écriture du nom dans le logo (« weby cloudy » ou « WebyCloudy »), définir le logo
      sur fond clair et en monochrome, exporter le logo en PNG, valider la version claire pour les documents imprimés.

---

## 2026-10-03 — Espace de supervision du super administrateur

**Demande** : un compte super admin avec une vue d'ensemble de tout ce qui se passe sur le site et de toutes les
statistiques, avec un tableau de bord personnalisé et un accès personnalisé.

**Réalisé** :
- Le compte super-admin existant (`admin`) reçoit un espace dédié, **Supervision** (`supervision/...`), réservé
  au rôle `superAdministrateur`. Aucun nouveau compte ni mot de passe créé (rien à mettre dans le dépôt).
  Le rôle est relu en base à chaque page : un compte rétrogradé perd l'accès tout de suite.
- **Tableau de bord personnalisable** : 10 blocs (chiffres clés, points d'attention, activité récente,
  fréquentation, pages les plus vues, provenance, demandes, projets, comptes, état du site). Dans *Personnaliser* :
  blocs affichés, ordre, largeur, période par défaut (7 j, 30 j, 90 j, 12 mois), page d'arrivée après connexion
  (Supervision ou Administration). Préférences en base (table `preferences`).
- **Audience** : mesure interne des pages publiques, sans cookie, sans outil externe, sans IP conservée
  (empreinte anonyme qui change chaque jour). Visiteurs, pages vues, évolution, pages, provenance (Google,
  Instagram, Leboncoin… et `?utm_source=`), appareils, heures, taux de contact. Robots, administrateurs et pages
  privées exclus. Table `visites`.
- **Journal d'activité** : connexions et échecs (IP tronquée, tentatives répétées signalées), créations et
  suppressions de compte, demandes et réponses, projets, documents déposés et téléchargés, changements de rôle.
  Filtres par catégorie, compte et période. Table `journal`. Visites et journal purgés après 400 jours.
- **Comptes** : chaque compte avec rôle, validation, dernière connexion, connexions, échecs, projets, demandes,
  documents. **État du site** : HTTPS, affichage des erreurs PHP, dossier des documents, mail, versions PHP et base,
  date de la dernière mise à jour des fichiers, disque, taille des tables.
- **Mise à jour de la base automatique** : `Installation` tient une version de schéma (`storage/.schema`) ; au premier
  chargement après déploiement, les 3 nouvelles tables sont créées sans toucher aux données.
- Lien *Supervision* dans le menu et dans la navigation de l'administration (super-admin uniquement).

**Fichiers / zones touchés** : `controllers/SuperAdministrateur/Supervision.controller.php`, `models/Supervision/`,
`views/SuperAdministrateur/supervision/`, `inc/partials/supervision_nav.php`, `public/CSS/supervision.css`,
`index.php`, `database.sql`, `models/Installation.class.php`, `controllers/MainController.controller.php` (audience),
contrôleurs Visiteur, Utilisateur, Espace, Administrateur, SuperAdministrateur (journal), `inc/header.php`,
`inc/partials/admin_nav.php`, `.gitignore`, `README.md`, `docs/DEPLOIEMENT.md`, `docs/DECISIONS.md`
**Vérifications** : `php -l` ; en local (PHP 8.3, MariaDB 10.11) : mise à niveau d'une base au schéma de `V2`
(tables créées, données conservées) et installation neuve ; Chromium à 1440 et 390 px sur les 6 pages de
supervision : aucun défilement horizontal, aucune erreur JavaScript, aucun warning PHP ; accès refusé à un
administrateur simple, à un client, à un visiteur et à un super-admin rétrogradé en cours de session ;
personnalisation (ordre, largeur, période, page d'arrivée) et retour à l'origine ; POST sans jeton CSRF refusé ;
non-régression des parcours contact, création de compte, projet, dépôt et téléchargement de document, réponse,
demande client, pages client et administration, avec les événements bien inscrits au journal.
**Référence** : PR de cette entrée (branche `claude/super-admin-dashboard-km2fp2`)
**Suites** : voir « Points en suspens » (contrôle après déploiement, liens `utm_source`, accès partiel éventuel
pour les administrateurs). Les statistiques démarrent à la mise en ligne : pas d'historique avant.

---

## 2026-10-03 — Production bloquée depuis le 2 octobre : redéploiement et vérification de Hostinger

**Demande** : reprendre le projet du cycle animé, relire l'historique et vérifier que la connexion avec Hostinger
fonctionne (le propriétaire ne voyait toujours pas l'animation après les PR #9 et #10).

**Réalisé** :
- Connecteur Hostinger : **opérationnel** dans cette session (lecture des réglages Git, des fichiers et des crons).
  Le site lui-même reste inaccessible depuis l'environnement de Claude Code (politique réseau).
- Cause réelle trouvée : **le déploiement automatique ne partait plus depuis la PR #4** (2 octobre au matin).
  Sur le serveur, il n'y avait ni `CLAUDE.md`, ni `docs/`, ni `inc/partials/cycle.php`, et `template.php` était
  l'ancienne version. Les PR #5, #6, #7, #9 et #10 n'avaient jamais été mises en ligne. Ce n'était pas un problème
  de cache.
- Réglages Git vérifiés (dépôt `RENZOZ78/WEBY`, branche `V2`, racine du site, déploiement actif, installation
  GitHub active), puis ré-enregistrés à l'identique par l'API (`hosting_git_update-auto-deployment-settings`) :
  le déploiement est parti immédiatement.
- Après déploiement : `cycle.php`, `theme.css`, `main.js`, `template.php` (liens `?v=`) et `docs/HISTORIQUE.md`
  ont exactement la taille de la dernière version de `V2` (commit `10c73a6`, PR #10). La production est à jour.
- Contrôles annexes : aucune tâche cron sur le compte ; les fichiers `.md` (dont `docs/`) sont bien refusés par
  `.htaccess`, la documentation n'est donc pas lisible depuis le site.

**Fichiers / zones touchés** : Hostinger : redéploiement Git de `webycloudy.com` ; `docs/HISTORIQUE.md`,
`docs/DEPLOIEMENT.md`, `docs/CONTEXTE_ACTIF.md`
**Vérifications** : comparaison des fichiers du serveur avec `V2` par l'API de fichiers Hostinger (voir ci-dessus).
Rendu visuel du site en ligne non vérifiable depuis cet environnement.
**Référence** : PR de cette entrée (documentation uniquement)
**Suites** : le propriétaire vérifie le cycle animé sur https://webycloudy.com (téléphone et ordinateur). Après
chaque fusion dans `V2`, contrôler que le serveur a bien reçu la nouvelle version ; si non, redéployer comme
ci-dessus. Trouver pourquoi le déclenchement automatique ne part plus (webhook GitHub de Hostinger).

---

## 2026-10-03 — Feuille de style et script versionnés (anciens fichiers en cache)

**Demande** : après la fusion de la PR #9, le propriétaire ne voit pas l'animation sur le site.

**Réalisé** :
- Constat : `V2` contient bien la fusion (`82bb1b6`). Le site n'a pas pu être consulté depuis l'environnement de
  Claude Code (webycloudy.com bloqué par sa politique réseau ; connecteur Hostinger non autorisé).
- Cause probable traitée : `theme.css` et `main.js` étaient appelés sans numéro de version. Le navigateur, ou le
  cache de l'hébergeur, pouvait donc garder les anciens fichiers. Ils sont désormais appelés avec
  `?v=<date de modification>` (aussi les CSS et JS propres à une page). Le numéro change à chaque déploiement.
- La fusion de cette correction redéclenche aussi le déploiement automatique, au cas où le précédent ne serait
  pas parti.

**Fichiers / zones touchés** : `views/common/template.php`
**Vérifications** : `php -l` ; accueil, prestations et contact en local : liens versionnés, aucun warning PHP ;
cycle animé toujours affiché (390 et 1440 px), aucune erreur JavaScript.
**Référence** : PR #10
**Suites** : si l'animation n'apparaît toujours pas, vérifier dans hPanel (*Sites → webycloudy.com → Avancé →
Git*) que le dernier déploiement porte le commit de la fusion, et vider le cache du site (LiteSpeed / CDN).

---

## 2026-10-03 — Cycle animé : effet étincelant à chaque phase, proportions rééquilibrées

**Demande** : un effet plus étincelant, plus « magique », chaque fois que le signal arrive sur une phase, avec un
texte plus brillant sur la phase en cours ; pastilles et textes trop petits par rapport au cercle, à équilibrer.

**Réalisé** :
- À chaque arrivée du signal sur une phase :
  - gerbe d'étincelles et de petites étoiles projetées autour de la pastille ;
  - flash de lumière derrière la pastille, deux ondes de choc et un reflet qui traverse la pastille ;
  - le nom de la phase s'illumine, traversé par un reflet, puis reste lumineux tant que la phase est active ;
  - au centre, le titre apparaît dans un éclat (du flou à la lumière, puis une lueur à la couleur de la phase).
- La pastille active « respire » (halo qui pulse), et une traînée de comète suit le point lumineux pendant
  ses déplacements.
- Proportions :
  - pastilles nettement plus grandes (jusqu'à 90 px au lieu de 72) ;
  - noms des phases (jusqu'à 1,35 rem), prestations (jusqu'à 0,96 rem), titre central (jusqu'à 1,8 rem) et
    détail (jusqu'à 1,04 rem) agrandis ;
  - pastilles un peu écartées du centre ;
  - logo central devenu un grand aigle en filigrane derrière le texte, plus lumineux au bouclage du cycle.
- Deux titres et un détail resserrés pour tenir sur deux lignes à cette taille : « Donner vie à vos projets »
  (Création), « Accélérer votre essor » et « Vendre plus, et plus cher, avec méthode. » (Performance).
- Effets désactivés en mode « mouvement réduit ».

**Fichiers / zones touchés** : `inc/partials/cycle.php`, `public/CSS/theme.css`, `public/Javascript/main.js`,
`docs/CHARTE_GRAPHIQUE.md`
**Vérifications** : `php -l` ; Chromium à 320, 360, 390, 412, 430, 768, 992, 1200 et 1440 px. Pour chaque phase,
contrôle automatique qu'aucun texte du centre ne touche une pastille ou un libellé, et qu'aucun libellé ne touche
un autre libellé, une flèche, les badges, le menu ou le bandeau défilant. Aucun défilement horizontal, aucune
erreur JavaScript. Effets vérifiés image par image sur une vidéo ; pause au survol et mouvement réduit retestés.
**Référence** : PR #9, fusionnée dans `V2` le 2026-10-03 à la demande du propriétaire (« intègre-moi la dernière
version, elle est pas mal avec la lumière étincelante ») : déploiement automatique sur https://webycloudy.com.
**Suites** : contrôler le rendu sur le site en ligne (téléphone et ordinateur).

---

## 2026-10-03 — Cycle animé : les quatre temps Conception, Création, Gestion, Performance

**Demande** : suivre le cycle logique des choses — on commence par la conception, ensuite la création, ensuite la
gestion et la performance — avec des mots plus éloquents pour le cercle et ses étapes.

**Réalisé** :
- Le cercle passe de six prestations à **quatre phases**. La lecture commence en haut à gauche et se fait dans le
  sens des aiguilles d'une montre, comme une page. Ensuite, la croissance nourrit de nouveaux projets et le cycle
  recommence. Chaque phase porte son nom et ses deux prestations, placés à l'extérieur du cercle. Au centre
  s'affichent une promesse et une phrase de détail :

  | Phase | Prestations | Promesse | Détail |
  |---|---|---|---|
  | Conception | Étude de marché · Business plan | Donner forme à votre idée | Un projet étudié, chiffré et prêt à convaincre. |
  | Création | Statuts & Kbis · Site & identité | Donner vie à votre entreprise | Société immatriculée, image affirmée, site en ligne. |
  | Gestion | Devis & factures · Paie & RH | Gérer en toute sérénité | Administratif, paie et RH : nous gérons, vous validez. |
  | Performance | Stratégie marketing · Acquisition clients | Accélérer votre croissance | Une stratégie mesurable pour vendre plus, et plus cher. |

  Les formules « Nous gérons, vous validez » et « vendre plus, et plus cher » sont celles des pages Gestion et
  Marketing.
- Une couleur par phase, tirée de la charte : or, orange, cyan, violet. L'arc de progression se colore phase par
  phase, et le centre comme le point lumineux prennent la couleur de la phase en cours.
- Icônes : compas (conception), fusée (création), dossier (gestion), courbe de croissance (performance).
- Rythme : 3,6 s par phase, dont la moitié de pause ; un tour dure environ 14 s.
- Petits écrans : le logo du centre est masqué jusqu'à 425 px de large environ, il est déjà dans le menu. Le
  détail est masqué en dessous de 335 px. La marge au-dessus du cercle est augmentée sur mobile pour les libellés
  du haut.

**Fichiers / zones touchés** : `inc/partials/cycle.php`, `public/CSS/theme.css`, `public/Javascript/main.js`,
`docs/DECISIONS.md`, `docs/CHARTE_GRAPHIQUE.md`
**Vérifications** : `php -l` ; Chromium à 320, 360, 390, 412, 430, 768, 992, 1200 et 1440 px. Pour chaque phase,
contrôle automatique qu'aucun texte du centre ne touche une pastille ou un libellé, et qu'aucun libellé ne touche
un autre libellé, une flèche, les badges du hero (mobile) ou le menu (ordinateur). Aucun défilement horizontal,
aucune erreur JavaScript. Pause au survol, reprise et mouvement réduit retestés ; vidéo d'un tour vérifiée.
**Référence** : PR #9
**Suites** : validation par le propriétaire sur le site en ligne.

---

## 2026-10-03 — Cycle animé : textes plus parlants et plus professionnels

**Demande** : les textes du cercle ne sont pas assez parlants ni assez professionnels ; trouver des textes qui
suivent mieux la logique de ce qui est fait.

**Réalisé** :
- Chaque étape a maintenant trois niveaux de texte, repris du vocabulaire des pages prestations :
  - sous la pastille, **la prestation** telle qu'un client la cherche ;
  - au centre, **l'objectif atteint pour le client** ;
  - en dessous, **le détail concret** de ce qui est livré.
- Au centre, la phase s'affiche aussi : « 01 / 06 · LANCEMENT » en or, « 04 / 06 · CROISSANCE » en cyan.

  | Prestation | Objectif | Détail |
  |---|---|---|
  | Étude de marché | Valider votre idée | Analyse du marché, de la concurrence et de vos clients cibles |
  | Business plan | Convaincre votre banque | Prévisionnel financier sur 3 ou 5 ans et dossier de prêt |
  | Statuts & Kbis | Créer votre société | Choix du statut, immatriculation et aides ACRE / ARCE |
  | Site internet | Être visible en ligne | Site vitrine ou e-commerce, référencement Google et maintenance |
  | Marketing | Attirer vos clients | Plan d'action, image de marque, réseaux sociaux et publicité |
  | Gestion & RH | Déléguer votre gestion | Devis et factures, fiches de paie, contrats de travail |

- Icône de la première étape : loupe sur graphique (celle de l'étude de marché sur le site) au lieu de l'ampoule.
- Mise en page du centre adaptée aux titres plus longs (taille réduite, coupures équilibrées). Sur les téléphones
  de moins de 385 px de large (dont les Android à 360 px), le logo du centre est masqué : il est déjà dans le menu.
  En dessous de 335 px, le détail et le « / 06 » sont masqués aussi : il reste la phase et l'objectif.

**Fichiers / zones touchés** : `inc/partials/cycle.php`, `public/CSS/theme.css`, `public/Javascript/main.js`,
`docs/DECISIONS.md`, `docs/CONTEXTE_ACTIF.md`
**Vérifications** : `php -l` ; Chromium à 320, 360, 390, 768, 992, 1200 et 1440 px. Pour chacune des six étapes,
contrôle automatique qu'aucun texte du centre ne touche une pastille ou un libellé ; aucun défilement horizontal,
aucune erreur JavaScript. Pause au survol, reprise et mouvement réduit retestés ; vidéo d'un tour vérifiée.
**Référence** : PR #9
**Suites** : validation des textes par le propriétaire sur le site en ligne.

---

## 2026-10-03 — Cycle animé des prestations en haut de l'accueil

**Demande** : une animation de type motion design en haut de la page d'accueil, qui montre dans un ordre logique
tout le processus des activités (de l'idée à la création, puis à la gestion) et toutes les prestations, de façon
circulaire.

**Réalisé** :
- Nouveau visuel à droite du titre de l'accueil (`inc/partials/cycle.php`) : six étapes disposées en cercle,
  dans le sens des aiguilles d'une montre — **Imaginer** (idée, étude de marché), **Financer** (business plan,
  prêt bancaire), **Créer** (statuts, Kbis, ACRE), **Construire** (site internet, image de marque, SEO),
  **Promouvoir** (réseaux sociaux, publicité, prospects), **Gérer** (paie, RH, devis et factures) — puis retour
  à Imaginer. Or pour les étapes du pack Lancement, cyan pour celles du pack Croissance (charte).
- Mouvement : un point lumineux fait le tour, marque une pause sur chaque étape et l'allume ; un arc en dégradé
  le suit ; le centre (logo) affiche le numéro, le nom et le détail de l'étape. Le tour complet dure 17 s ; à la
  fin du tour, l'arc s'efface et le logo fait un petit rebond. Anneaux pointillés qui tournent lentement,
  flèches qui indiquent le sens. Apparition des étapes en cascade au chargement.
- Chaque étape est un lien vers la page de la prestation ; le survol ou le focus clavier d'une étape met le
  cycle en pause sur celle-ci. L'animation s'arrête quand le cycle n'est plus à l'écran ou que l'onglet est
  masqué, et reste immobile si l'utilisateur demande la réduction des mouvements.
- Le cycle remplace la photo, les deux cartes flottantes et la maquette de tableau de bord du hero de l'accueil :
  les chiffres illustratifs (+38 %, + 120 prospects, × 2,4) ne sont donc plus affichés (point en suspens réglé).
  Les pages prestations gardent leur visuel photo.
- Titre de l'accueil : les mots qui tournent (« votre chiffre d'affaires »…) passent maintenant à la ligne sur
  ordinateur au lieu de déborder de leur colonne (ils auraient chevauché le cycle entre 1100 et 1440 px).

**Fichiers / zones touchés** : `inc/partials/cycle.php` (nouveau), `inc/header.php`, `public/CSS/theme.css`,
`public/Javascript/main.js`, `docs/CHARTE_GRAPHIQUE.md`, `docs/CONTEXTE_ACTIF.md`, `docs/DECISIONS.md`, `README.md`
**Vérifications** : `php -l` ; accueil, prestations et contact sans warning PHP en local (PHP 8.3, sans base) ;
Chromium à 390, 992, 1100, 1200, 1280, 1440 et 1920 px : aucune erreur JavaScript, pas de défilement horizontal,
pas de chevauchement titre / cycle ; survol (pause puis reprise) et mouvement réduit testés ; vidéo du cycle
enregistrée et vérifiée image par image.
**Référence** : PR #9
**Suites** : faire valider l'ordre et les libellés des étapes par le propriétaire ; contrôler l'animation sur
le site en ligne après fusion (téléphone et ordinateur).

---

## 2026-10-02 — Charte graphique extraite du site

**Demande** : extraire la charte graphique (kit de marque) du site et l'ajouter au dépôt en bonne et due forme.

**Réalisé** :
- `docs/CHARTE_GRAPHIQUE.md` : logo, couleurs (bleu nuit, or, accents cyan / violet / rose), dégradés,
  typographies (Poppins, Inter), arrondis, ombres, composants, règles pour Instagram, Leboncoin et documents.
  Valeurs relevées dans `public/CSS/theme.css` et `inc/header.php` ; rien n'a été inventé ni modifié sur le site.
- Rédigé depuis Chat, qui n'a pas le droit d'écriture sur le dépôt : fichier remis au propriétaire, puis ajouté
  au dépôt par Claude Code avec cette entrée.
- Correction après la revue automatique de la PR : `logo_aigle.svg` n'est pas l'aigle seul, il contient aussi le
  nom « weby cloudy » sous l'aigle (vérifié par rendu du fichier). La charte le dit désormais, donne les couleurs
  du fichier (`#cc921f`, `#e6c584`), demande de ne pas réécrire le nom à côté hors site, et signale que
  `logo_aigle.png` / `logo_aigle2.png` portent l'ancien nom « Weby Weba Solutions ».

**Fichiers / zones touchés** : `docs/CHARTE_GRAPHIQUE.md`, `docs/CONTEXTE_ACTIF.md`, `README.md`
**Vérifications** : chaque valeur comparée aux variables `--wc-*` du thème en ligne ; fichiers du logo affichés
dans Chromium pour en voir le contenu ; documentation seule.
**Référence** : PR #7
**Suites** : fichier de l'aigle seul ; écriture officielle du nom dans le logo ; logo sur fond clair et
monochrome ; exports PNG du logo ; version claire pour les documents imprimés à valider.

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
