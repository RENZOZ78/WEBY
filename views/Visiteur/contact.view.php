<?php
  // Contenu principal de la page (le template inclut le header et le footer)
  require "./inc/content_contact.php";
  // Bloc « Qui suis-je » : affiché seulement quand il est renseigné dans config/config.php
  $qui_sur_contact = true;
  include "./inc/partials/qui_suis_je.php";
?>
