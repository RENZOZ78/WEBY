<?php
  $intro = [
    "kicker" => "Stratégie marketing & croissance — dès 500 €",
    "titre" => "Vendre plus, et plus cher",
    "image" => "public/Assets/images/strategie_marketing/st3.png",
    "alt" => "Cible atteinte",
    "legende" => ["Vendre plus, et plus cher", "Audit, acquisition, image de marque"],
    "inverse" => true,
    "paragraphes" => [
      "Votre société souffre d'un manque de visibilité ? Vous n'arrivez pas à obtenir autant de clients que vous le souhaitez ? Nous avons la solution.",
      "Objectif : développer votre chiffre d'affaires avec une stratégie claire, mesurable et adaptée à votre secteur.",
    ],
    "points" => [
      ["fa-magnifying-glass-chart", "Audit de votre activité", "Comment vendre plus et plus cher ? Nous analysons votre offre, vos prix, vos canaux et votre concurrence, et nous vous remettons un plan d'action."],
      ["fa-users-viewfinder", "Acquisition clients", "Stratégies pour attirer des prospects qualifiés : réseaux sociaux, publicité Google, Facebook, Instagram et TikTok, e-réputation."],
      ["fa-palette", "Image de marque", "Identité visuelle, positionnement concurrentiel et message : une marque qui inspire confiance et qui se démarque."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Canaux",
    "titre" => "Présent là où sont vos clients",
    "sombre" => true,
    "items" => [
      ["fa-brands fa-google", "Google", "Fiche d'établissement, avis clients et campagnes Google Ads pour apparaître en tête des recherches."],
      ["fa-brands fa-instagram", "Facebook & Instagram", "Animation de votre communauté et publicités ciblées selon l'âge, la ville et les centres d'intérêt."],
      ["fa-brands fa-tiktok", "TikTok & Snapchat", "Des formats vidéo pour toucher une audience jeune et massive."],
    ],
  ];
  include "inc/partials/features.php";

  $chiffres = [["95 %", "de clients satisfaits"], ["48h", "pour recevoir votre devis"], ["Mensuel", "rapport de résultats dans votre espace"], ["France", "entière, visio ou RDV"]];
  include "inc/partials/stats.php";

  $tarifs = [
    "titre" => "Pack Croissance — marketing",
    "texte" => "Combinez les offres selon vos objectifs. Devis gratuit.",
    "offres" => [
      ["nom" => "Audit & stratégie", "prix" => "500 €", "periode" => "", "vedette" => true, "details" => ["Audit de votre activité", "Plan d'action : vendre plus et plus cher", "Positionnement concurrentiel", "Restitution en visio"]],
      ["nom" => "Acquisition clients", "prix" => "300 €", "periode" => "/mois", "details" => ["Réseaux sociaux animés", "Publicité Google, Meta, TikTok", "Gestion de votre e-réputation", "Rapport mensuel"]],
      ["nom" => "Image de marque", "prix" => "Sur devis", "periode" => "", "details" => ["Logo & identité visuelle", "Charte graphique", "Supports de communication", "Message & positionnement"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Appelez-nous pour transformer votre activité";
  $cta_image = "public/Assets/images/site%20internet/rx3.png";
  include "inc/partials/cta.php";
?>
