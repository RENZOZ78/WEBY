<?php
  include "inc/partials/contact_form.php";

  $features = [
    "kicker" => "Nos garanties",
    "titre" => "Travailler avec nous, en toute sérénité",
    "items" => [
      ["fa-bolt", "Traitement rapide", "Nous traitons vos demandes sous 48h."],
      ["fa-lock", "Paiement sécurisé", "CB, PayPal, et paiement en 2x ou 3x dès 200€ avec Alma."],
      ["fa-headset", "Une équipe disponible", "Notre service client vous répond de 10h à 18h."],
    ],
  ];
  include "inc/partials/features.php";
?>
