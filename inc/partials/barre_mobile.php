<?php
  /* Barre fixe en bas d'ecran, sur telephone uniquement (pages visiteur) : appeler ou demander un devis.
   * Incluse depuis views/common/template.php, avant le pied de page (qui lui laisse la place en CSS).
   * Le clic sur le lien tel: est compte par main.js comme les autres clics telephone. */
  $site = $site ?? require("config/config.php");
  //sur la page contact, le formulaire est deja la : on y descend au lieu de recharger la page
  $lienDevis = (($page_courante ?? "") === "contact") ? "#contact" : URL."contact";
?>
<nav class="barre-mobile" aria-label="Contact rapide">
  <a href="tel:<?= str_replace(' ', '', $site['telephone']) ?>" class="btn btn-outline-light" aria-label="Appeler le <?= $site['telephone'] ?>"><i class="fas fa-phone" aria-hidden="true"></i>Appeler</a>
  <a href="<?= $lienDevis ?>" class="btn btn-gold">Devis gratuit</a>
</nav>
