<?php
  $site = $site ?? require("config/config.php");
?>
<section class="section-sm pb-5">
  <div class="container">
    <div class="cta-band" data-aos="zoom-in">
      <div class="cta-bg" aria-hidden="true"><img src="<?= URL ?><?= $cta_image ?? "img/pc_lumineux.jpg" ?>" alt="" loading="lazy"></div>
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <h2 class="mb-2"><?= $cta_titre ?? "Êtes-vous prêt à passer à l'action ?" ?></h2>
          <p class="mb-0">Parlez-nous de votre projet : nous revenons vers vous sous 48h avec une proposition adaptée.</p>
        </div>
        <div class="col-lg-4">
          <div class="cta-actions">
            <a href="<?= URL ?>contact" class="btn btn-gold btn-lg">Demander un devis gratuit</a>
            <a href="tel:<?= str_replace(' ', '', $site['telephone']) ?>" class="btn btn-outline-light btn-lg btn-tel" aria-label="Appeler le <?= $site['telephone'] ?>"><i class="fas fa-phone" aria-hidden="true"></i><?= $site['telephone'] ?></a>
            <small><?= $site['horaires'] ?></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
