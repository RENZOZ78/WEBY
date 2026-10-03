# Contexte actif — WebyCloudy

**Point d'entrée unique** pour tout assistant (Claude Code, Cowork, Chat) et pour le propriétaire.
À lire en premier, avant toute tâche ou tout conseil. Doit rester **court** (une page) : l'ancien part dans
[`HISTORIQUE.md`](HISTORIQUE.md), les choix durables dans [`DECISIONS.md`](DECISIONS.md).

Dernière mise à jour : 2026-10-03 — par Claude Code (cycle animé de l'accueil mis en ligne)

> Ce dépôt est **public** : ne rien écrire ici de confidentiel (mots de passe, données clients, chiffres privés).

## Situation actuelle

- **Site** : V2 en ligne sur https://webycloudy.com depuis le 2026-10-02 (PHP 8.4 / MySQL, Hostinger,
  branche `V2` déployée automatiquement). Détails : [`DEPLOIEMENT.md`](DEPLOIEMENT.md).
- **Contenu du site** : vitrine de l'agence, prestations (lancement & financement, gestion, site internet,
  marketing & croissance), espace client et administration.
- **Phase** : validation de la V2 après mise en ligne (sécurité des accès, mails, tarifs, contenus).
- **Charte graphique** : [`CHARTE_GRAPHIQUE.md`](CHARTE_GRAPHIQUE.md) — à suivre pour tout visuel (site, Instagram,
  Leboncoin, documents).

## Priorités en cours (3 maximum)

1. **Sécuriser la production** : changer les mots de passe communiqués pendant la mise en ligne, tester les mails.
2. **Valider les contenus** : tarifs indicatifs, cycle animé de l'accueil (4 phases), photos réelles.
3. **Nettoyer** : fichiers inutiles déployés (`.idea/`, `.vscode/`, `node_modules/`), `backup_v1`, anciennes copies
   sur `webycloudy.fr` / `.xyz`.

Le détail à cocher est dans « Points en suspens » de [`HISTORIQUE.md`](HISTORIQUE.md) — ne pas le recopier ici.

## Hors site (marque, acquisition)

À compléter par le propriétaire ou par l'assistant qui travaille le sujet — état non renseigné à ce jour :

| Sujet | État | Dernière avancée |
|---|---|---|
| SEO | non renseigné | — |
| Instagram | non renseigné | — |
| Leboncoin | non renseigné | — |
| Acquisition / conversion | non renseigné | — |

## Sujets ouverts / à trancher

- Lien entre ce site (agence, `webycloudy.com`) et la plateforme de documents IA (projet Firebase
  `weby-cloudy-prod`, autre dépôt) : deux produits distincts sous le même nom — positionnement à clarifier.

## Qui fait quoi

| Outil | Rôle | Écrit dans le dépôt ? |
|---|---|---|
| Claude Code | code, mise en ligne, Hostinger | oui, par PR vers `V2` |
| Cowork | pilotage, contenus, marketing, fichiers locaux | oui, par PR vers `V2` (fichiers `docs/` uniquement sauf demande) |
| Chat | réflexion, rédaction, stratégie | lit ; fait consigner ses conclusions par Cowork ou Claude Code |
