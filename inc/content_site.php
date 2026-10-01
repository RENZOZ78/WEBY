<?php
  $intro = [
    "kicker" => "Site internet",
    "titre" => "Un site moderne qui travaille pour vous",
    "image" => "public/Assets/images/site%20internet/ws2.png",
    "alt" => "Création de site internet",
    "paragraphes" => [
      "Nous créons votre site internet afin que vous puissiez capter de nouveaux clients et renforcer l'identité de votre activité.",
      "Tous nos sites sont optimisés pour le référencement (SEO) et s'adaptent aux ordinateurs, tablettes et mobiles.",
    ],
    "points" => [
      ["fa-wand-magic-sparkles", "Modernité", "Nous mettons un point d'honneur à vous proposer des sites modernes, afin que vous puissiez attirer une large palette de clients."],
      ["fa-globe", "Présence web", "Nous accentuons votre présence sur le web, pour que vous profitiez de tout le potentiel de votre entreprise sur internet… et obteniez plus de clients."],
      ["fa-star", "E-réputation", "Parce que la réputation de votre société est primordiale, nous veillons à ce que vos clients soient satisfaits et qu'ils le disent tout haut."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Inclus",
    "titre" => "Ce que vous obtenez",
    "items" => [
      ["fa-mobile-screen", "Compatible partout", "Votre site s'affiche parfaitement sur téléphone, tablette, Android et Apple."],
      ["fa-store", "Boutique en ligne", "Achat, rendez-vous, agenda : vos clients peuvent tout faire sur votre site, en un clic."],
      ["fa-gauge-high", "Rapide et dynamique", "Un site à la pointe de la technologie et du design, fluide et dynamique."],
    ],
  ];
  include "inc/partials/features.php";

  include "inc/partials/realisations.php";

  $tarifs = [
    "titre" => "Choisissez le site qu'il vous faut",
    "texte" => "Nom de domaine, hébergement et référencement : tout est compris.",
    "offres" => [
      ["nom" => "Site vitrine", "prix" => "250€", "periode" => "", "details" => ["Site responsive", "Site référencé SEO", "Nom de domaine", "Hébergement"]],
      ["nom" => "Blog", "prix" => "400€", "periode" => "", "vedette" => true, "details" => ["Site responsive", "Site référencé SEO", "Espace membre", "Articles optimisés SEO"]],
      ["nom" => "Site e-commerce", "prix" => "700€", "periode" => "", "details" => ["Site responsive", "Site référencé", "Pages articles et prestations", "Paiement sécurisé"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Faites passer votre activité dans une autre dimension";
  include "inc/partials/cta.php";
?>
