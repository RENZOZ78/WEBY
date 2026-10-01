<?php
  $intro = [
    "kicker" => "Création de société",
    "titre" => "Lancez votre entreprise sans stress administratif",
    "image" => "public/Assets/images/entreprise/BP.png",
    "alt" => "Business plan",
    "paragraphes" => [
      "Nous vous accompagnons dans la création de votre société, puis dans tous les besoins liés à votre activité : gestion, modifications et, si besoin, fermeture.",
      "Vous vous concentrez sur votre métier, nous nous occupons des démarches.",
    ],
    "points" => [
      ["fa-file-signature", "Création", "Rédaction des statuts, publication au Journal officiel, constitution du dossier et obtention du K-bis."],
      ["fa-users-gear", "Gestion", "Gestion de la paie, des entrées et sorties de salariés (DPAE) et des déclarations sociales (DSN)."],
      ["fa-pen-to-square", "Modifications", "Changement de dénomination, de gérance, d'activité ou répartition des parts d'associés."],
      ["fa-door-closed", "Fermeture", "Modification des statuts, publication au Journal officiel et obtention du nouveau K-bis."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Pourquoi nous",
    "titre" => "Un accompagnement de A à Z",
    "items" => [
      ["fa-chart-pie", "Business plan", "Nous construisons avec vous un business plan solide pour convaincre vos partenaires."],
      ["fa-stamp", "Démarches simplifiées", "Statuts, annonces légales, dossier : nous gérons toutes les formalités."],
      ["fa-handshake", "Suivi dans la durée", "Après la création, nous restons votre interlocuteur pour la gestion de votre société."],
    ],
  ];
  include "inc/partials/features.php";

  $tarifs = [
    "titre" => "Les tarifs",
    "texte" => "Des prix transparents pour chaque étape de la vie de votre société.",
    "offres" => [
      ["nom" => "Création de société", "prix" => "550€", "periode" => "", "vedette" => true, "details" => ["Rédaction des statuts", "Journal officiel", "Constitution du dossier", "Obtention du K-bis"]],
      ["nom" => "Gestion de société", "prix" => "50€", "periode" => "/mois", "details" => ["Gestion de la paie", "Entrée de nouveau salarié (DPAE)", "Déclarations sociales (DSN)", "Fin de contrat salarié"]],
      ["nom" => "Modifications", "prix" => "300€", "periode" => "/mois", "details" => ["Modification de dénomination", "Modification de gérance", "Modification d'activité", "Modification des parts d'associés"]],
      ["nom" => "Fermeture de société", "prix" => "200€", "periode" => "/mois", "details" => ["Modification des statuts", "Journal officiel", "Constitution du dossier", "Obtention du nouveau K-bis"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Prêt à créer votre société ?";
  include "inc/partials/cta.php";
?>
