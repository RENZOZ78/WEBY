<?php
  // Pied de page : métiers (inc/secteurs.php) et identité légale (config/config.php), affichée seulement si renseignée
  $metiersPied = require "inc/secteurs.php";
  $piedLegal = array_filter([
    htmlspecialchars(trim((string)($site['legal_forme'] ?? ""))),
    trim((string)($site['legal_siret'] ?? "")) !== "" ? "SIRET ".htmlspecialchars(trim($site['legal_siret'])) : "",
  ]);
?>
<!-- footer -->
<footer class="wc-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3">
        <a href="<?= URL ?>" class="brand d-inline-block mb-3" aria-label="WebyCloudy, retour à l'accueil">
          <img src="<?= URL ?>public/Assets/images/accueil/logo_aigle.svg" alt="WebyCloudy" width="69" height="56">
        </a>
        <p class="mb-0">Business plan, création de société, gestion administrative, site internet et stratégie marketing : une seule agence pour lancer et faire grandir votre entreprise.</p>
      </div>
      <div class="col-sm-6 col-lg-2">
        <h4>Prestations</h4>
        <ul>
          <li><a href="<?= URL ?>prestations/lancement">Business plan &amp; création</a></li>
          <li><a href="<?= URL ?>prestations/gestion">Gestion &amp; administratif</a></li>
          <li><a href="<?= URL ?>prestations/sites">Site internet</a></li>
          <li><a href="<?= URL ?>prestations/marketing">Marketing &amp; croissance</a></li>
        </ul>
      </div>
      <div class="col-sm-6 col-lg-4">
        <h4>Métiers</h4>
        <ul class="pied-metiers">
          <?php foreach($metiersPied as $slugMetier => $metier) : ?>
            <li><a href="<?= URL ?>secteurs/<?= $slugMetier ?>"><?= htmlspecialchars($metier['nom']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-3">
        <h4>Nous joindre</h4>
        <ul class="contact-line">
          <li><i class="fas fa-phone"></i><a href="tel:<?= str_replace(' ', '', $site['telephone']) ?>"><?= $site['telephone'] ?></a></li>
          <li><i class="fas fa-envelope"></i><a href="mailto:<?= $site['mail_contact'] ?>"><?= $site['mail_contact'] ?></a></li>
          <li><i class="far fa-clock"></i><?= $site['horaires'] ?></li>
        </ul>
        <p class="pied-info">Devis gratuit, réponse sous 48 h ouvrées.</p>
      </div>
    </div>
    <nav class="pied-liens" aria-label="Liens du pied de page">
      <a href="<?= URL ?>">Accueil</a>
      <a href="<?= URL ?>contact">Contact</a>
      <a href="<?= URL ?>login">Espace client</a>
      <a href="<?= URL ?>creerCompte">Créer un compte</a>
      <a href="<?= URL ?>mentions-legales">Mentions légales</a>
      <a href="<?= URL ?>confidentialite">Confidentialité</a>
    </nav>
    <div class="bottom d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>&copy; <?= date('Y') ?> WebyCloudy — Tous droits réservés</span>
      <?php if(!empty($piedLegal)) : ?>
        <span class="pied-legal"><?= implode(" · ", $piedLegal) ?></span>
      <?php endif; ?>
    </div>
  </div>
</footer>
