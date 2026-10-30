# Décisions — WebyCloudy

Choix **durables** en vigueur. Une ligne par décision, la plus récente en haut.
Ne pas revenir sur une décision sans l'accord du propriétaire ; si elle change, barrer l'ancienne ligne
et ajouter la nouvelle (on garde la trace). Le détail du contexte est dans [`HISTORIQUE.md`](HISTORIQUE.md).

| Date | Décision | Raison |
|---|---|---|
| 2026-10-30 | Formulaire de contact : refusé s'il est envoyé moins de 3 s après l'affichage, s'il contient du code de lien, plus de 2 liens ou une formule de démarchage en anglais (« traffic », backlinks, casino, crypto…) ; « SEO » et un lien seul restent acceptés ; le visiteur refusé voit un message avec le mail et le téléphone, son texte est conservé, le refus est noté au journal. Le super administrateur peut supprimer une demande de spam | messages « traffic » de Stephen et Christopher passés malgré le champ piège : ils faussaient les demandes, les points d'attention et le taux de contact |
| 2026-10-30 | Audience comptée par le navigateur (jeton signé renvoyé par `main.js`, avec le jeton anti-CSRF) et non plus à la génération de la page ; visites venues de sites de spam ignorées ; clics sur le téléphone, le mail et WhatsApp mesurés et comptés dans le taux de contact ; anciens chiffres (`visites`) conservés mais plus affichés ; robots et spams écartés comptés à part (robots déclarés, spam de provenance, robots déguisés = pages servies jamais confirmées par le navigateur) et affichés à côté des visiteurs | 464 « visiteurs » en 30 jours dont 89 % en accès direct, des sources de spam et 17 % de mobiles : les robots déguisés en navigateurs faussaient les chiffres et faisaient croire à un site qui ne convertit pas |
| 2026-10-30 | Inscription : login de 3 à 30 caractères (lettres sans accent, chiffres, `.` `-` `_`), champ piège anti-robot, mail de validation sans le login, renvoi limité (1 par quart d'heure, 3 par jour) ; le super administrateur peut supprimer les comptes jamais validés | compte de robot au login publicitaire (2026-10-30) : le site ne doit pas servir à envoyer du spam depuis `info@webycloudy.com` |
| 2026-10-08 | Référencement : adresse officielle `https://webycloudy.com/` (sans `www`, accueil sur `/` et non `/accueils`) déclarée en URL canonique ; plan du site `sitemap.xml` généré par le site ; anciennes adresses V1 redirigées en 301 ; erreurs, connexion et espaces privés en `noindex` | alerte Search Console du 2026-10-07 (404, pages en double) ; garder le référencement acquis par l'ancien site |
| 2026-10-06 | Métiers accompagnés : bandeau défilant de cartes sans photo à l'accueil et une page par métier (`secteurs/{métier}`) avec problématiques, solutions reliées aux prestations et gains ; contenu centralisé dans `inc/secteurs.php` | demande du propriétaire ; que chaque visiteur se reconnaisse dans un problème concret au lieu de tuiles génériques |
| 2026-10-06 | Réalisations : 4e carte **Sweet Home BTP**, site de démonstration de l'agence (entreprise fictive, `sweet-home-btp.webycloudy.com`), affichée avec la mention « site démo » ; exception assumée au principe « uniquement de vraies réalisations », qui reste la règle pour les clients | demande du propriétaire ; montrer le savoir-faire actuel sans faire passer la démo pour un client |
| ~~2026-10-04~~ | ~~Réalisations affichées : Fiteos (lien vers son domaine `fiteos.click`), Delta-Immo, Magic Food Panam ; Dofinvest retiré~~ — complétée le 2026-10-06 (Sweet Home BTP ajouté) | demande du propriétaire |
| 2026-10-03 | Supervision réservée au super administrateur ; audience mesurée par le site lui-même (sans cookie, sans outil externe, sans IP conservée), journal d'activité en base | vue d'ensemble demandée par le propriétaire, sans bandeau de consentement ni dépendance à Google Analytics |
| 2026-10-03 | Hero de l'accueil : cycle animé en quatre phases, Conception → Création → Gestion → Performance (deux prestations et une promesse par phase), à la place de la photo et de la maquette chiffrée | le cycle logique d'une entreprise, voulu par le propriétaire ; tout l'accompagnement d'un coup d'œil, sans chiffres inventés |
| 2026-10-02 | GitHub (`docs/`) est la source de vérité commune à Claude Code, Cowork et Chat | un seul état du projet, lu avant d'agir, mis à jour après |
| 2026-10-02 | Adresse du site : `info@webycloudy.com` (affichage, notifications, expéditeur) | boîte déjà utilisée, cohérente avec le SPF du domaine |
| 2026-10-02 | Branche `V2` = production, déploiement Git automatique Hostinger ; travail sur branche + PR | mise en ligne sans manipulation, retour arrière par revert |
| 2026-10-02 | PHP 8.4 en production | version du développement local |
| 2026-10-02 | Secrets uniquement dans `config/config.local.php` sur le serveur, jamais dans le dépôt | dépôt public |
| 2026-10-01 | Design sombre (bleu nuit, or du logo, cyan, violet), Bootstrap 5.3 | image « pro qui donne envie » |
| 2026-10-01 | Tables `produits` / `commandes` abandonnées au profit de `projets`, `documents`, `demandes`, `messages` | le site vend des prestations suivies, pas des produits |
| 2026-10-01 | Le formulaire de contact crée une demande en base | rien ne se perd si le mail ne part pas |
| ~~2026-10-01~~ | ~~Uniquement de vraies réalisations (Fiteos, Delta-Immo, Magic Food Panam, Dofinvest)~~ — remplacée le 2026-10-04 (Dofinvest retiré) ; le principe « uniquement de vraies réalisations » reste en vigueur | suppression des faux logos clients |

## Décisions proposées, non confirmées

- Tarifs indicatifs (gestion mensuelle, acquisition 300 €/mois, site + blog 450 €, e-commerce 700 €) : à valider.
