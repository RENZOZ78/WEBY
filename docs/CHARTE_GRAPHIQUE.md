# Charte graphique — WebyCloudy

Kit de marque extrait du site V2 (https://webycloudy.com) tel qu'il est en ligne au 2026-10-02.
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
| Halo | lueur dorée autour du logo sur fond sombre : `drop-shadow(0 0 12px rgba(224,171,60,.5))` |
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
| Or — couleur principale | `#e0ab3c` | `--wc-gold` |
| Or clair — liens, icônes, accents de texte | `#f3c868` | `--wc-gold-2` |
| Orange — fin du dégradé or | `#ff8a3d` | `--wc-orange` |
| Texte posé sur l'or | `#1a1205` | — |

### Accents

| Rôle | Hex | Variable |
|---|---|---|
| Cyan — second accent (pack Croissance, données) | `#3fd0ff` | `--wc-cyan` |
| Bleu — milieu du dégradé cyan | `#5b7cff` | — |
| Violet — troisième accent | `#8b5cf6` | `--wc-violet` |
| Rose — notifications, badges | `#ff5c8a` | `--wc-pink` |

### Texte

| Rôle | Hex | Variable |
|---|---|---|
| Titres | `#ffffff` | — |
| Texte courant | `#eef1f8` | `--wc-text` |
| Texte secondaire | `#a7b0ca` | `--wc-muted` |

### États

| Rôle | Hex | Variable |
|---|---|---|
| Succès | `#3ddc97` | `--wc-green` |
| Erreur | `#ff6b6b` | `--wc-red` |
| Avertissement | or `#e0ab3c` | `--wc-gold` |

### Dégradés (tous à 135°)

| Nom | Composition | Usage |
|---|---|---|
| Or | `#f3c868` → `#e0ab3c` (45 %) → `#ff8a3d` | bouton principal, mots mis en avant, chiffres |
| Cyan | `#3fd0ff` → `#5b7cff` (55 %) → `#8b5cf6` | bouton secondaire, pack Croissance |
| Rose | `#ff5c8a` → `#8b5cf6` | halos décoratifs, badge super-administrateur |
| Fond du hero | `#0a1330` → `#0e1a40` (60 %) → `#121f4d`, à 160° | bandeau d'en-tête, fonds de visuels |

Proportions à respecter : environ 70 % de bleu nuit, 20 % de blanc et gris-bleu (texte), 10 % d'or.
Le cyan, le violet et le rose restent des touches ; l'or est la seule couleur d'action principale.

## 3. Typographie

| Usage | Police | Graisses utilisées |
|---|---|---|
| Titres, chiffres, nom de la marque | **Poppins** | 600, 700 (titres), 800 (chiffres clés) |
| Texte courant, boutons, formulaires | **Inter** | 400, 500, 600 |
| Secours | system-ui, -apple-system, Segoe UI, sans-serif | — |

- Titres : blancs, interlettrage resserré (-0,015 em).
- Texte courant : interligne 1,75.
- Sur-titres (« kicker ») : capitales, 0,78 rem, graisse 700, interlettrage 0,16 em, or clair ou cyan.
- Tailles de titres du site : H1 de 2,2 à 3,9 rem ; H2 de 1,8 à 2,6 rem (adaptées à la largeur d'écran).

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
| Lueur or | `0 0 40px rgba(224,171,60,.35)` |
| Lueur cyan | `0 0 40px rgba(63,208,255,.3)` |

Signature visuelle : fond bleu nuit, halos flous de couleur (or, bleu, rose) dans les angles, trame de points
blancs très discrète, cartes à bordure fine et translucide.

## 5. Composants

- **Bouton principal** : dégradé or, texte `#1a1205`, pilule, graisse 600, ombre dorée.
- **Bouton secondaire** : dégradé cyan, texte blanc.
- **Bouton discret** : fond blanc à 6 %, bordure blanche à 18 %, texte blanc.
- **Étiquette / sur-titre encadré** : fond or à 12 %, bordure or à 35 %, texte or clair, capitales.
- **Carte** : fond `#111c3d`, bordure blanche à 9 %, arrondi 20 px ; se soulève au survol.
- **Offre vedette** : fond bleu `#1a2a5c` → `#2a2a6e`, bordure or, lueur or.
- **Icônes** : Font Awesome 6 (version gratuite), en or clair ou sur pastille en dégradé.

## 6. Images et mouvement

- Photos : cadrage professionnel (équipe, bureau, entrepreneurs), bord arrondi, fondu sombre bleu nuit en bas
  pour poser un texte blanc dessus.
- Animations : douces et courtes (0,2 à 0,35 s), apparition par glissement vers le haut ; désactivées quand
  l'utilisateur demande la réduction des mouvements.
- Exception : le **cycle des prestations** du hero de l'accueil (`inc/partials/cycle.php`) tourne en continu
  (un tour en 14 s environ). Ses quatre phases ont chacune une couleur : Conception or `#f3c868`, Création orange
  `#ff8a3d`, Gestion cyan `#3fd0ff`, Performance violet `#8b5cf6` (texte `#b69cff`). C'est le visuel de référence
  pour présenter le processus WebyCloudy (Instagram, présentations), avec les mêmes mots : Conception, Création,
  Gestion, Performance.

## 7. Déclinaison hors site

- **Instagram** : fond `#070d1f` ou dégradé du hero, titre en Poppins Bold blanc avec un mot clé en dégradé or,
  texte en Inter, logo en bas, un seul accent (or) par visuel ; cyan réservé aux contenus « croissance ».
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
