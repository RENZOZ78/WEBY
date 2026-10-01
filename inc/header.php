<?php
  //renvoie "active" si le lien correspond a la page courante
  $actif = function($prefixes) use ($page_courante){
    foreach((array)$prefixes as $prefixe){
      if($page_courante === $prefixe || strpos($page_courante, $prefixe."/") === 0) return " active";
    }
    return "";
  };
  $estAccueil = !empty($hero_accueil);
  $estCompact = !empty($hero_compact);
?>
<!-- Navigation ---------------------------------------->
<nav class="navbar navbar-expand-lg wc-nav<?= $estCompact ? ' nav-solid' : '' ?>" id="main-nav" aria-label="Navigation principale">
  <div class="container">
    <a href="<?= URL ?>accueils" class="navbar-brand">
      <img src="<?= URL ?>public/Assets/images/accueil/logo_aigle.svg" alt="" width="58" height="47">
      <span class="brand-text">Weby<span>Cloudy</span></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Ouvrir le menu">
      <i class="fas fa-bars text-white"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item">
          <a href="<?= URL ?>accueils" class="nav-link<?= $actif(["accueils", ""]) ?>">Accueil</a>
        </li>

        <!-- deroulant prestations -->
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle<?= $actif(["prestations", "entreprises"]) ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">Prestations</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= URL ?>prestations/entreprises"><i class="fas fa-briefcase"></i>Création de société</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/sites"><i class="fas fa-laptop-code"></i>Site internet</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/reseaux"><i class="fas fa-hashtag"></i>Réseaux sociaux</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/marketing"><i class="fas fa-bullhorn"></i>Publicité &amp; marketing</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?= URL ?>contact" class="nav-link<?= $actif("contact") ?>">Contact</a>
        </li>

        <!-- espace administration -->
        <?php if(Securite::estAdministrateur() || Securite::estSuperAdministrateur()) : ?>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle<?= $actif("administration") ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administration</a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if(Securite::estSuperAdministrateur()) : ?>
                <li><a class="dropdown-item" href="<?= URL ?>administration/gestionFullUtilisateur"><i class="fas fa-user-gear"></i>Gestion complète</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="<?= URL ?>administration/droits"><i class="fas fa-user-shield"></i>Gérer les droits</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/gestionUtilisateurs"><i class="fas fa-users"></i>Utilisateurs</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/gestionCommandes"><i class="fas fa-receipt"></i>Commandes</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/gestionProduits"><i class="fas fa-box"></i>Produits</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- compte -->
        <?php if(!Securite::estConnecte()) : ?>
          <li class="nav-item">
            <a href="<?= URL ?>login" class="nav-link<?= $actif(["login", "creerCompte"]) ?>"><i class="far fa-user me-1"></i>Mon compte</a>
          </li>
        <?php else : ?>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle<?= $actif("compte") ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="far fa-user me-1"></i><?= $_SESSION['profil']['login'] ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= URL ?>compte/profil"><i class="fas fa-id-card"></i>Mon profil</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/modificationPassword"><i class="fas fa-key"></i>Mot de passe</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/deconnexion"><i class="fas fa-right-from-bracket"></i>Se déconnecter</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <li class="nav-item nav-cta ms-lg-2">
          <a href="<?= URL ?>contact" class="btn btn-gold btn-sm">Demander un devis</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bandeau d'en-tete ---------------------------------------->
<?php if($estAccueil) : ?>
  <header class="wc-hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-up">
          <span class="eyebrow"><i class="fas fa-feather-pointed"></i><?= $uvp ?></span>
          <h1>Faites <span class="accent">décoller</span> votre activité</h1>
          <p class="lead"><?= $hero_texte ?? "" ?></p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="#prestations" class="btn btn-gold btn-lg">Découvrir nos prestations</a>
            <a href="<?= URL ?>contact" class="btn btn-outline-light btn-lg">Parlons de votre projet</a>
          </div>
          <div class="hero-badges">
            <span><i class="fas fa-bolt"></i>Réponse sous 48h</span>
            <span><i class="fas fa-mobile-screen"></i>Sites responsive &amp; SEO</span>
            <span><i class="fas fa-credit-card"></i>Paiement en 2x ou 3x</span>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
          <div class="hero-visual">
            <img class="hero-img" src="<?= URL ?>public/Assets/images/site%20internet/si3.png" alt="Site internet affiché sur ordinateur, tablette et mobile">
            <div class="hero-card card-a">
              <span class="icon"><i class="fas fa-chart-line"></i></span>
              <span><strong>Plus de visibilité</strong>Site, réseaux &amp; pub</span>
            </div>
            <div class="hero-card card-b">
              <span class="icon"><i class="fas fa-briefcase"></i></span>
              <span><strong>Société créée</strong>Statuts, JO, K-bis</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
<?php elseif($estCompact) : ?>
  <header class="wc-hero hero-compact">
    <div class="container">
      <span class="eyebrow mb-2"><?= $uvp ?></span>
      <h1><?= $H1 ?></h1>
    </div>
  </header>
<?php else : ?>
  <header class="wc-hero hero-page">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="<?= !empty($hero_image) ? 'col-lg-7' : 'col-lg-9' ?>" data-aos="fade-up">
          <span class="eyebrow"><?= $uvp ?></span>
          <h1><?= $H1 ?></h1>
          <?php if(!empty($hero_texte)) : ?><p class="lead"><?= $hero_texte ?></p><?php endif; ?>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="<?= URL ?>contact" class="btn btn-gold">Demander un devis</a>
            <a href="#tarifs" class="btn btn-outline-light">Voir les tarifs</a>
          </div>
        </div>
        <?php if(!empty($hero_image)) : ?>
          <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-delay="150">
            <div class="hero-visual"><img class="hero-img" src="<?= URL.$hero_image ?>" alt=""></div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </header>
<?php endif; ?>
