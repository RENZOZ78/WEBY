# Charte graphique — WebyCloudy

Kit de marque extrait du site V2 (https://webycloudy.com), mis à jour le 2026-11-21 : **style plus sobre**
(décision du propriétaire) — même identité bleu nuit + or, mais or en aplat, sans halo lumineux ni texte en dégradé.
**Source de vérité technique** : `public/CSS/theme.css` (variables `--wc-*`) et `inc/header.php`.
Si le thème change, mettre ce document à jour dans la même PR.

À utiliser pour tout ce qui porte la marque : site, espace client, Instagram, annonces Leboncoin, devis,
business plans, présentations.

## 1. Logo

| Élément | Valeur |
|---|---|
| Fichier du logo | `public/Assets/images/accueil/logo_aigle.svg` (version PNG 98 × 79 px : `logo_wc2.png`) |
| Contenu du fichier | l'aigle **et**, dessous, le nom « weby cloudy » (minuscules, deux mots, police étroite) |
| Couleurs du fichier | aigle or `#cc921f` ; nom or `#cc921f` cerné d'or clair `#e6c584` |
| Aigle seul | **aucun fichier à ce jour** (à créer) |
| Nom écrit en texte | **Weby**Cloudy, en un seul mot, W et C en capitales |
| Écriture du nom | Poppins Bold (700) ; « Weby » en blanc `#ffffff`, « Cloudy » en or clair `#f3c868` |
| Disposition sur le site | fichier du logo à gauche, nom en Poppins à droite, centrés verticalement (le nom apparaît donc aussi, en petit, sous l'aigle) |
| Halo | aucun : le logo est posé tel quel sur le fond sombre (l'ancienne lueur dorée est retirée) |
| Taille sur le site | 46 px de haut dans le menu (38 px au défilement), 56 px en pied de page |

`logo_aigle.png` et `logo_aigle2.png` portent l'ancien nom « Weby Weba Solutions » : ne pas les utiliser.

Règles d'usage :
- Toujours sur fond sombre (bleu nuit de la palette). Pas de version sur fond clair définie à ce jour.
- Hors site, utiliser le fichier du logo tel quel (aigle + nom dessous), **sans** réécrire le nom à côté.
  La disposition du site (aigle à gauche, nom en Poppins à droite) demande un fichier de l'aigle seul, qui
  n'existe pas encore.
- Ne pas déformer, ne pas recolorer le logo.
- Dans les textes et titres, écrire « WebyCloudy ». Le fichier du logo écrit « weby cloudy » : l'écriture
  officielle du nom dans le logo reste à trancher par le propriétaire.
- Garder autour du logo une marge libre d'au moins la moitié de sa hauteur.

## 2. Couleurs

### Fonds et surfaces (bleu nuit)

| Rôle | Hex | Variable |
|---|---|---|
| Fond principal | `#070d1f` | `--wc-bg` |
| Fond secondaire (sections alternées) | `#0c1530` | `--wc-bg-2` |
| Surface (cartes) | `#111c3d` | `--wc-surface` |
| Surface relevée | `#172550` | `--wc-surface-2` |
| Pied de page | `#040816` | — |
| Bordure | blanc à 9 % | `--wc-border` |
| Bordure marquée | blanc à 18 % | `--wc-border-strong` |

### Couleur de marque (or)

| Rôle | Hex | Variable |
|---|---|---|
| Or — couleur principale | `#e6b440` | `--wc-gold` |
| Or clair — liens, icônes, accents de texte | `#f7d77a` | `--wc-gold-2` |
| Or profond — fin du dégradé or | `#d9a02c` | `--wc-gold-3` |
| Ambre — problèmes à résoudre, phase « Création » du cycle | `#f09a55` | `--wc-orange` |
| Texte posé sur l'or | `#1a1205` | — |

### Accents

| Rôle | Hex | Variable |
|---|---|---|
| Bleu ciel — accent secondaire discret (pack Croissance, solutions, informations) ; remplace le cyan vif | `#8fc4ea` | `--wc-cyan` |
| Bleu glacier — variante claire du bleu ciel ; remplace le violet | `#c9d6f5` | `--wc-violet` |
| Rose — notifications, badges d'état uniquement | `#ff5c8a` (fond de pastille avec texte blanc : `#c2335f`) | `--wc-pink` |

### Texte

| Rôle | Hex | Variable |
|---|---|---|
| Titres | `#ffffff` | — |
| Texte courant | `#eef1f8` | `--wc-text` |
| Texte secondaire | `#a7b0ca` | `--wc-muted` |
| Texte indicatif des champs (placeholder) | `#939ebd` | — |
| Contour des champs et des boutons discrets | blanc à 40 % | `--wc-border-control` |
| Anneau de focus clavier | or très clair `#fde7a3`, 2 px, décalé de 2 px | `--wc-focus` |

Contraste : tout texte fait au moins 4,5:1 sur son fond (3:1 pour les grands titres et les contours des éléments
cliquables). Aucun texte sous 12 px, y compris sur téléphone.

### États

| Rôle | Hex | Variable |
|---|---|---|
| Succès | `#3ddc97` | `--wc-green` |
| Erreur | `#ff6b6b` | `--wc-red` |
| Avertissement | or `#e0ab3c` | `--wc-gold` |

### Aplats et dégradés

**Or premium** (décision du 2026-11-22) : l'or jaune lumineux est la signature de la marque. Dégradé or
`--wc-grad-gold` (`#fde7a3` → `#f3c95c` → `#d9a02c`, à 135°) sur les boutons d'action, le mot doré du titre, les
chiffres clés et les prix ; lueur dorée douce sur les boutons (`--wc-glow-gold`) ; une seule lumière dorée fixe
dans le haut de page. Aucun autre dégradé de couleur : ni orange, ni violet, ni cyan. `--wc-grad-cyan` et
`--wc-grad-pink` donnent un aplat : ne plus les utiliser. Textes en dégradé sur bleu nuit : 8,3:1 au plus sombre.

| Nom | Composition | Usage |
|---|---|---|
| Fond du hero | `#0a1330` → `#0d183a` (60 %) → `#101c45`, à 160° | bandeau d'en-tête, fonds de visuels (seul dégradé conservé, ton sur ton) |
| Bandeau d'appel | `#15244f` → `#1b2b5f`, à 135° | bloc « contactez-nous », ton sur ton |

Proportions à respecter : environ 70 % de bleu nuit, 20 % de blanc et gris-bleu (texte), 10 % d'or.
Le bleu ciel et le rose restent des touches ; **l'or est la seule couleur d'action** (un bouton secondaire est un
simple contour blanc, jamais une deuxième couleur).

## 3. Typographie

| Usage | Police | Graisses utilisées |
|---|---|---|
| Titres, chiffres, nom de la marque | **Poppins** | 600, 700 (titres), 800 (chiffres clés) |
| Texte courant, boutons, formulaires | **Inter** | 400, 500, 600 |
| Secours | system-ui, -apple-system, Segoe UI, sans-serif | — |

- Titres : blancs, interlettrage resserré (-0,015 em).
- Texte courant : interligne 1,75.
- Sur-titres (« kicker ») : capitales, 0,78 rem, graisse 700, interlettrage 0,16 em, or clair ou bleu ciel.
- Mots mis en avant dans un titre : dégradé or premium (repli or clair `#f7d77a` si le navigateur ne le gère pas).
- Tailles de titres du site : H1 de 2,2 à 3,9 rem ; H2 de 1,8 à 2,6 rem (adaptées à la largeur d'écran). Le titre de
  l'accueil s'ajuste à sa colonne pour que le mot qui change tienne toujours sur une ligne.
- Paragraphes d'introduction : 75 caractères par ligne au plus.

Les deux polices sont gratuites (Google Fonts) et disponibles dans Canva.

## 4. Formes, ombres et effets

| Élément | Valeur |
|---|---|
| Arrondi des cartes | 20 px (`--wc-radius`) |
| Arrondi des petits éléments, champs | 12 px (`--wc-radius-sm`) |
| Grandes cartes (packs, bandeau d'appel) | 28 à 30 px |
| Boutons, badges, étiquettes | pilule (arrondi complet) |
| Pastilles d'icône | carré arrondi de 44 à 58 px, arrondi 12 à 16 px |
| Ombre | `0 10px 30px rgba(0,0,0,.35)` |
| Ombre forte | `0 30px 70px rgba(0,0,0,.5)` |
| Lueurs colorées | aucune (ni halo autour des boutons, des icônes ou du logo, ni ombre colorée) |

Signature visuelle : fond bleu nuit uni, or en aplat réservé aux actions et aux repères, trame de points blancs
très discrète dans l'en-tête, cartes à bordure fine et translucide. Pas de halos flous de couleur.

## 5. Composants

- **Bouton principal** : dégradé or premium, texte `#1a1205`, pilule, graisse 600, lueur dorée douce (plus forte au survol).
- **Bouton secondaire** : contour blanc à 50 %, texte blanc, fond transparent (blanc plein au survol).
- **Bouton discret** : fond blanc à 6 %, bordure blanche à 40 %, texte blanc.
- **Sur-titre** : texte or clair en capitales, sans encadré. Étiquette des packs : fond or à 15 %, bordure or à 40 %.
- **Focus clavier** : anneau or clair de 2 px autour de tout élément cliquable ou champ.
- **Carte** : fond `#111c3d`, bordure blanche à 9 %, arrondi 20 px ; au survol, ombre et bordure plus marquées
  (léger soulèvement de 3 px au plus, pas d'inclinaison).
- **Offre vedette** : surface relevée `#172550`, filet or, prix en dégradé or, lueur dorée très légère ; pas de bordure animée.
- **Icônes** : Font Awesome 6 (version gratuite), en or clair ou bleu ciel sur pastille discrète, ou en sombre
  sur pastille or.

## 6. Images et mouvement

- Photos : cadrage professionnel (équipe, bureau, entrepreneurs), bord arrondi, fondu sombre bleu nuit en bas
  pour poser un texte blanc dessus.
- Animations : douces et courtes (0,2 à 0,35 s), sans rebond, apparition par glissement vers le haut ; désactivées
  quand l'utilisateur demande la réduction des mouvements. Le bandeau défilant de l'accueil est lent (un tour en
  90 s) et s'arrête au survol ou au toucher.
- Exception : le **cycle des prestations** du hero de l'accueil (`inc/partials/cycle.php`) tourne en continu
  (un tour en 14 s environ). Ses quatre phases ont chacune une teinte en aplat : Conception or clair `#f3c868`,
  Création ambre `#f0a868`, Gestion bleu ciel `#8fc4ea`, Performance bleu glacier `#c9d6f5`. C'est le visuel de
  référence pour présenter le processus WebyCloudy (Instagram, présentations), avec les mêmes mots : Conception,
  Création, Gestion, Performance. À chaque arrivée du signal sur une phase : la pastille se remplit de la teinte de
  la phase et une seule onde fine s'élargit (plus d'étincelles, de flash ni de reflet) ; l'aigle du logo est en
  filigrane au centre.

## 7. Déclinaison hors site

- **Instagram** : fond `#070d1f` ou dégradé du hero, titre en Poppins Bold blanc avec un mot clé en or clair (aplat),
  texte en Inter, logo en bas, un seul accent (or) par visuel ; bleu ciel réservé aux contenus « croissance ».
- **Leboncoin** : première photo sur fond bleu nuit avec le logo et la promesse en blanc et or, lisible en
  vignette.
- **Documents clients** (devis, business plan) : pour l'impression, texte bleu nuit `#070d1f` sur fond blanc,
  titres en Poppins, or `#e0ab3c` pour les filets et les titres de section. Version claire à valider par le
  propriétaire (non définie dans le site).

## 8. À compléter

- Fichier de l'aigle seul (sans le nom), pour la disposition du site et les petits formats.
- Écriture officielle du nom dans le logo (« weby cloudy » dans le fichier, « WebyCloudy » sur le site).
- Version du logo sur fond clair et version monochrome.
- Exports PNG du logo en plusieurs tailles (le seul PNG à jour, `logo_wc2.png`, fait 98 × 79 px).
- Fichier de favicon et image de partage (réseaux sociaux).
