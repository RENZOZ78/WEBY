<?php
  $intro = [
    "kicker" => "Site internet professionnel — dès 300 €",
    "titre" => "Un site moderne qui vous apporte des clients",
    "image" => "public/Assets/images/site%20internet/ws2.png",
    "alt" => "Création de site internet",
    "paragraphes" => [
      "Votre société souffre d'un manque de visibilité ? Un site internet professionnel, c'est votre vitrine ouverte 24h/24, partout en France.",
      "Nous créons votre site, nous le référençons sur Google et nous le maintenons : vous n'avez rien à gérer.",
    ],
    "points" => [
      ["fa-laptop-code", "Site vitrine ou e-commerce", "Un site moderne et responsive, parfaitement lisible sur PC, tablette et mobile. Boutique en ligne, prise de rendez-vous, agenda : tout est possible."],
      ["fa-magnifying-glass", "Référencement (SEO)", "Pages optimisées, textes travaillés, fiche Google : pour être trouvé par vos clients quand ils vous cherchent."],
      ["fa-screwdriver-wrench", "Maintenance et fluidité garanties", "Mises à jour, sauvegardes, sécurité et rapidité : votre site reste fluide et disponible."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Inclus",
    "titre" => "Ce que vous obtenez",
    "sombre" => true,
    "items" => [
      ["fa-mobile-screen", "Compatible partout", "PC, tablette, Android, iPhone : votre site s'adapte à tous les écrans."],
      ["fa-store", "Vendez en ligne", "Paiement sécurisé, catalogue, prise de rendez-vous : vos clients commandent en un clic."],
      ["fa-gauge-high", "Rapide et sécurisé", "Un site fluide, hébergé et protégé, avec nom de domaine et certificat HTTPS."],
    ],
  ];
  include "inc/partials/features.php";

  include "inc/partials/realisations.php";

  $tarifs = [
    "titre" => "Choisissez le site qu'il vous faut",
    "texte" => "Nom de domaine, hébergement, référencement et maintenance : tout est compris.",
    "offres" => [
      ["nom" => "Site vitrine", "prix" => "300 €", "periode" => "", "vedette" => true, "details" => ["Responsive PC / mobile", "Référencement SEO", "Nom de domaine & hébergement", "Maintenance"]],
      ["nom" => "Site + blog", "prix" => "450 €", "periode" => "", "details" => ["Tout le site vitrine", "Espace membre", "Articles optimisés SEO", "Maintenance"]],
      ["nom" => "Site e-commerce", "prix" => "700 €", "periode" => "", "details" => ["Tout le site vitrine", "Catalogue & panier", "Paiement sécurisé", "Maintenance"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Faites passer votre activité dans une autre dimension";
  include "inc/partials/cta.php";
?>
