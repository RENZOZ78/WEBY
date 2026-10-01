<?php
  $intro = [
    "kicker" => "Réseaux sociaux",
    "titre" => "Une communauté engagée autour de votre marque",
    "image" => "public/Assets/images/site%20internet/rx.png",
    "alt" => "Icônes de réseaux sociaux",
    "paragraphes" => [
      "Il est temps de mieux exploiter les réseaux sociaux à votre profit grâce à une gestion dynamique.",
      "Nous créons et animons votre communauté pour que vos clients parlent de vous… en bien.",
    ],
    "points" => [
      ["fa-people-group", "Création de communauté", "Nous lançons vos pages Facebook et Instagram et attirons vos premiers abonnés."],
      ["fa-calendar-check", "Animation régulière", "Publications, stories et réponses aux messages : votre communauté reste active."],
      ["fa-star", "E-réputation", "Parce que la réputation de votre société est primordiale, nous veillons à ce que vos clients soient satisfaits et qu'ils le disent tout haut."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Plateformes",
    "titre" => "Présent là où sont vos clients",
    "items" => [
      ["fa-brands fa-facebook-f", "Facebook", "Une page professionnelle animée et une communauté fidèle."],
      ["fa-brands fa-instagram", "Instagram", "Des visuels soignés qui donnent envie de vous découvrir."],
      ["fa-brands fa-snapchat", "Snapchat", "Une présence au plus près d'une audience jeune."],
      ["fa-brands fa-google", "Google", "Une fiche d'établissement à jour et des avis valorisés."],
    ],
  ];
  include "inc/partials/features.php";

  $tarifs = [
    "titre" => "Nos offres",
    "texte" => "Combinez les offres selon vos besoins.",
    "offres" => [
      ["nom" => "Votre site", "prix" => "350€", "periode" => "", "details" => ["Site statique", "Site dynamique", "Gestion de site", "Nom de domaine + hébergement"]],
      ["nom" => "Réseaux sociaux", "prix" => "300€", "periode" => "/mois", "vedette" => true, "details" => ["Facebook", "Instagram", "Snapchat", "Google"]],
      ["nom" => "E-réputation", "prix" => "200€", "periode" => "/mois", "details" => ["Création de communauté", "Animation de votre communauté", "Communauté Facebook & Instagram", "Gestion de votre e-réputation"]],
    ],
  ];
  include "inc/partials/pricing.php";

  include "inc/partials/cta.php";
?>
