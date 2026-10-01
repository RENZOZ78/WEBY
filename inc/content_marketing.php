<?php
  $intro = [
    "kicker" => "Publicité & marketing",
    "titre" => "Touchez la bonne cible, au bon moment",
    "image" => "public/Assets/images/strategie_marketing/st3.png",
    "alt" => "Cible atteinte",
    "paragraphes" => [
      "Nous écoutons vos demandes, identifions vos besoins, puis nous réalisons votre publicité sur internet afin d'atteindre vos objectifs.",
      "Nous mettons en place votre stratégie marketing digitale pour que vous puissiez obtenir des clients plus rapidement.",
    ],
    "points" => [
      ["fa-bullseye", "Ciblage précis", "Nous définissons votre audience idéale pour que chaque euro investi compte."],
      ["fa-rectangle-ad", "Campagnes publicitaires", "Création et pilotage de vos campagnes Google, Facebook, Instagram et TikTok."],
      ["fa-chart-line", "Suivi des résultats", "Nous mesurons les performances et optimisons vos campagnes en continu."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Canaux",
    "titre" => "Vos campagnes sur toutes les plateformes",
    "items" => [
      ["fa-brands fa-google", "Google Ads", "Apparaissez en tête des recherches de vos futurs clients."],
      ["fa-brands fa-facebook-f", "Facebook Ads", "Des publicités ciblées selon l'âge, la ville et les centres d'intérêt."],
      ["fa-brands fa-instagram", "Instagram Ads", "Des visuels percutants dans le fil et les stories."],
      ["fa-brands fa-tiktok", "TikTok Ads", "Des formats vidéo pour toucher une audience massive."],
    ],
  ];
  include "inc/partials/features.php";

  $tarifs = [
    "titre" => "Nos offres",
    "texte" => "Combinez les offres selon vos objectifs.",
    "offres" => [
      ["nom" => "Publicité", "prix" => "200€", "periode" => "/mois", "vedette" => true, "details" => ["Google Ads", "Instagram Ads", "Facebook Ads", "TikTok Ads"]],
      ["nom" => "Réseaux sociaux", "prix" => "300€", "periode" => "/mois", "details" => ["Facebook", "Instagram", "Snapchat", "Google"]],
      ["nom" => "E-réputation", "prix" => "200€", "periode" => "/mois", "details" => ["Création de communauté", "Animation de votre communauté", "Communauté Facebook & Instagram", "Gestion de votre e-réputation"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Passez au niveau supérieur et touchez votre cible";
  include "inc/partials/cta.php";
?>
