# Critique Impeccable — https://webycloudy.com (2026-11-21)

Method: dual-agent (A : revue design · B : détecteur + navigateur)
Pages : /, /prestations/lancement, /prestations/sites, /secteurs/vtc, /secteurs/restauration, /contact — 1440x900 et 390x844.

## Score (Nielsen) : 22/32 — Acceptable (69 %)

| # | Heuristique | Score | Problème clé |
|---|---|---|---|
| 1 | État du système | 3 | Mot tournant et carrousel bougent sans état |
| 2 | Monde réel | 3 | ACRE/ARCE, Kbis, CMA, JO, SEO jamais expliqués |
| 3 | Contrôle | 3 | Bandeau défilant non pausable sur mobile |
| 4 | Cohérence | 3 | 5 libellés différents pour la même action (/contact) ; bouton cyan→violet |
| 5 | Prévention des erreurs | 3 | Formulaire solide, sujet prérempli |
| 6 | Reconnaissance | 2 | 12 pages métier absentes du menu et du pied de page |
| 7 | Flexibilité | n/a | Vitrine |
| 8 | Esthétique / minimalisme | 2 | Accueil 8 200 px (16 900 px mobile), offre et prix répétés 3 fois |
| 9 | Récupération d'erreur | 3 | Messages clairs sous le champ |
| 10 | Aide | n/a | Vitrine (FAQ manquante) |

## Spécificité : générique à ~75 %
Fond bleu nuit + halos or/violet, étiquettes en capitales au-dessus de chaque titre, boutons pilule dégradés, tuiles icônes, 4 étapes, bandeau défilant, banque d'images. Détecteur : 89 constats sur l'accueil (halos radiaux x25, ombres lumineuses x21, texte en dégradé x12, kickers x7, contraste x7, palette « IA » violet/cyan, Inter 75-86 % du texte). Exception : les pages métier, concrètes et spécifiques.

## Problèmes prioritaires
1. [P1] Preuves invérifiables et pas d'identité légale : « 95 % de clients satisfaits » (inc/header.php:110, inc/content_lancement.php, inc/content_marketing.php) sans base ; /mentions-legales en 404 ; ni SIRET ni personne visible ; réalisations sur *.netlify.app.
2. [P1] Chemin vers le contact dilué : action principale du héros = « Découvrir nos packs » ; pas de bouton d'appel sur mobile ; « Appelez-nous… Allons-y ! » mène au formulaire (inc/partials/cta.php:11).
3. [P1] Accueil trop long et redondant : packs + 6 prestations + 4 tarifs (mêmes prix), cycle 4 phases + méthode 4 étapes.
4. [P1] Contraste : bouton cyan 2,3:1 (theme.css:90), placeholders du formulaire 3,2:1, petits textes du cycle 10,5 px en mobile, focus clavier quasi invisible.
5. [P2] Pages métier introuvables, décor et photos génériques.

## Personas
- Jordan (débutant) : « 95 % » sans source, jargon, rien après « Envoyer », aucun nom humain, titre doublé sur /contact.
- Riley (méthodique) : mentions légales 404, /accueils en double de /, réalisations netlify.app.
- Casey (mobile) : 16 900 px, pas de bouton Appeler, animations non pausables.
- Sam (clavier) : anneau de focus invisible sur fond nuit.

## Forces
Pages métier (inc/secteurs.php) ; tarifs « à partir de » + 2x/3x ; formulaire propre ; 0 erreur JS, 0 requête en échec, pas de débordement mobile.
