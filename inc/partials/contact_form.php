<?php
  $site = $site ?? require("config/config.php");
  $offreDemandee = htmlspecialchars(mb_substr(isset($_GET['offre']) ? (string)$_GET['offre'] : ($offre_defaut ?? ""), 0, 100));
?>
<section class="section section-alt" id="contact">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5" data-aos="fade-right">
        <span class="kicker">Contact</span>
        <h2 class="mb-3">Parlons de votre projet</h2>
        <p class="text-muted-wc mb-4">Devis gratuit. Écrivez-nous ou appelez-nous : nous vous répondons sous 48h, partout en France, en visio ou en rendez-vous.</p>
        <div class="contact-info">
          <div class="item">
            <span class="icon"><i class="fas fa-phone"></i></span>
            <div><small>Téléphone</small><a href="tel:<?= str_replace(' ', '', $site['telephone']) ?>"><?= $site['telephone'] ?></a></div>
          </div>
          <div class="item">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <div><small>Email</small><a href="mailto:<?= $site['mail_contact'] ?>"><?= $site['mail_contact'] ?></a></div>
          </div>
          <div class="item">
            <span class="icon"><i class="far fa-clock"></i></span>
            <div><small>Service client</small><strong><?= $site['horaires'] ?></strong></div>
          </div>
        </div>
      </div>
      <div class="col-lg-7" data-aos="fade-left">
        <form method="post" action="<?= URL ?>validation_contact" class="form-card needs-validation" novalidate>
          <?= Securite::csrfField() ?>
          <div class="hp-field" aria-hidden="true">
            <label for="site_web">Ne pas remplir</label>
            <input type="text" id="site_web" name="site_web" tabindex="-1" autocomplete="off">
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="contact-nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="contact-nom" name="nom" autocomplete="name" required maxlength="100">
              <div class="invalid-feedback">Indiquez votre nom.</div>
            </div>
            <div class="col-md-6">
              <label for="contact-mail" class="form-label">Email</label>
              <input type="email" class="form-control" id="contact-mail" name="mail" autocomplete="email" required maxlength="150">
              <div class="invalid-feedback">Indiquez une adresse email valide.</div>
            </div>
            <div class="col-12">
              <label for="contact-sujet" class="form-label">Sujet</label>
              <input type="text" class="form-control" id="contact-sujet" name="sujet" maxlength="120" value="<?= $offreDemandee ? 'Demande de devis : '.$offreDemandee : '' ?>" placeholder="Création de site, de société, publicité…">
            </div>
            <div class="col-12">
              <label for="contact-message" class="form-label">Message</label>
              <textarea class="form-control" id="contact-message" name="message" rows="5" required maxlength="5000" placeholder="Décrivez votre projet en quelques lignes"></textarea>
              <div class="invalid-feedback">Écrivez votre message.</div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-gold btn-lg w-100"><i class="fas fa-paper-plane me-2"></i>Envoyer le message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
