<!-- footer -->
<footer class="wc-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <a href="<?= URL ?>accueils" class="brand d-inline-block mb-3">
          <img src="<?= URL ?>public/Assets/images/accueil/logo_aigle.svg" alt="WebyCloudy" width="69" height="56">
        </a>
        <p class="mb-0">Business plan, création de société, gestion administrative, site internet et stratégie marketing : une seule agence pour lancer et faire grandir votre entreprise.</p>
      </div>
      <div class="col-6 col-lg-2 offset-lg-1">
        <h4>Prestations</h4>
        <ul>
          <li><a href="<?= URL ?>prestations/lancement">Business plan &amp; création</a></li>
          <li><a href="<?= URL ?>prestations/gestion">Gestion &amp; administratif</a></li>
          <li><a href="<?= URL ?>prestations/sites">Site internet</a></li>
          <li><a href="<?= URL ?>prestations/marketing">Marketing &amp; croissance</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <h4>Le site</h4>
        <ul>
          <li><a href="<?= URL ?>accueils">Accueil</a></li>
          <li><a href="<?= URL ?>contact">Contact</a></li>
          <li><a href="<?= URL ?>login">Espace client</a></li>
          <li><a href="<?= URL ?>creerCompte">Créer un compte</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h4>Nous joindre</h4>
        <ul class="contact-line">
          <li><i class="fas fa-phone"></i><a href="tel:<?= str_replace(' ', '', $site['telephone']) ?>"><?= $site['telephone'] ?></a></li>
          <li><i class="fas fa-envelope"></i><a href="mailto:<?= $site['mail_contact'] ?>"><?= $site['mail_contact'] ?></a></li>
          <li><i class="far fa-clock"></i><?= $site['horaires'] ?></li>
        </ul>
      </div>
    </div>
    <div class="bottom d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>&copy; <?= date('Y') ?> WebyCloudy — Tous droits réservés</span>
      <span>Fait avec passion pour les entrepreneurs</span>
    </div>
  </div>
</footer>
