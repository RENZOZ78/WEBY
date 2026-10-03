# Décisions — WebyCloudy

Choix **durables** en vigueur. Une ligne par décision, la plus récente en haut.
Ne pas revenir sur une décision sans l'accord du propriétaire ; si elle change, barrer l'ancienne ligne
et ajouter la nouvelle (on garde la trace). Le détail du contexte est dans [`HISTORIQUE.md`](HISTORIQUE.md).

| Date | Décision | Raison |
|---|---|---|
| 2026-10-03 | Hero de l'accueil : cycle animé des prestations (Imaginer → Financer → Créer → Construire → Promouvoir → Gérer) à la place de la photo et de la maquette chiffrée | montrer tout l'accompagnement d'un coup d'œil, sans chiffres inventés |
| 2026-10-02 | GitHub (`docs/`) est la source de vérité commune à Claude Code, Cowork et Chat | un seul état du projet, lu avant d'agir, mis à jour après |
| 2026-10-02 | Adresse du site : `info@webycloudy.com` (affichage, notifications, expéditeur) | boîte déjà utilisée, cohérente avec le SPF du domaine |
| 2026-10-02 | Branche `V2` = production, déploiement Git automatique Hostinger ; travail sur branche + PR | mise en ligne sans manipulation, retour arrière par revert |
| 2026-10-02 | PHP 8.4 en production | version du développement local |
| 2026-10-02 | Secrets uniquement dans `config/config.local.php` sur le serveur, jamais dans le dépôt | dépôt public |
| 2026-10-01 | Design sombre (bleu nuit, or du logo, cyan, violet), Bootstrap 5.3 | image « pro qui donne envie » |
| 2026-10-01 | Tables `produits` / `commandes` abandonnées au profit de `projets`, `documents`, `demandes`, `messages` | le site vend des prestations suivies, pas des produits |
| 2026-10-01 | Le formulaire de contact crée une demande en base | rien ne se perd si le mail ne part pas |
| 2026-10-01 | Uniquement de vraies réalisations (Fiteos, Delta-Immo, Magic Food Panam, Dofinvest) | suppression des faux logos clients |

## Décisions proposées, non confirmées

- Tarifs indicatifs (gestion mensuelle, acquisition 300 €/mois, site + blog 450 €, e-commerce 700 €) : à valider.
