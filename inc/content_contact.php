<?php
  //le titre « Parlons de votre projet » est deja en haut de la page : pas de second titre au-dessus du formulaire
  $contact_sans_titre = true;
  include "inc/partials/contact_form.php";
  unset($contact_sans_titre);

  $features = [
    "kicker" => "Nos garanties",
    "titre" => "Travailler avec nous, en toute sérénité",
    "items" => [
      ["fa-bolt", "Réponse sous 48h", "Un devis gratuit et une réponse à chaque demande sous 48h ouvrées."],
      ["fa-lock", "Paiement sécurisé", "CB, PayPal, et paiement en 2x ou 3x dès 200 € avec Alma."],
      ["fa-headset", "Un suivi dans votre espace", "Projets, documents et échanges : tout est centralisé dans votre espace client."],
    ],
  ];
  include "inc/partials/features.php";
?>
