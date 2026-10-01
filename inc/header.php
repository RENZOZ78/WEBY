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
  $estAdmin = Securite::estAdministrateur() || Securite::estSuperAdministrateur();
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
          <a href="#" class="nav-link dropdown-toggle<?= $actif("prestations") ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">Prestations</a>
          <ul class="dropdown-menu">
            <li><h6 class="dropdown-header text-uppercase small" style="color:var(--wc-gold-2)">Lancement &amp; financement</h6></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/lancement"><i class="fas fa-rocket"></i>Business plan &amp; création de société</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header text-uppercase small" style="color:var(--wc-cyan)">Croissance</h6></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/gestion"><i class="fas fa-folder-open"></i>Gestion &amp; administratif</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/sites"><i class="fas fa-laptop-code"></i>Site internet</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>prestations/marketing"><i class="fas fa-bullhorn"></i>Marketing &amp; croissance</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?= URL ?>contact" class="nav-link<?= $actif("contact") ?>">Contact</a>
        </li>

        <!-- espace administration -->
        <?php if($estAdmin) : ?>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle<?= $actif("administration") ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administration</a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= URL ?>administration/tableau"><i class="fas fa-gauge-high"></i>Tableau de bord</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/demandes"><i class="fas fa-inbox"></i>Demandes</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/projets"><i class="fas fa-diagram-project"></i>Projets</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/gestionUtilisateurs"><i class="fas fa-users"></i>Clients</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>administration/droits"><i class="fas fa-user-shield"></i>Droits</a></li>
              <?php if(Securite::estSuperAdministrateur()) : ?>
                <li><a class="dropdown-item" href="<?= URL ?>administration/gestionFullUtilisateur"><i class="fas fa-user-gear"></i>Gestion complète</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <!-- compte -->
        <?php if(!Securite::estConnecte()) : ?>
          <li class="nav-item">
            <a href="<?= URL ?>login" class="nav-link<?= $actif(["login", "creerCompte"]) ?>"><i class="far fa-user me-1"></i>Espace client</a>
          </li>
        <?php else : ?>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle<?= $actif("compte") ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="far fa-user me-1"></i><?= $_SESSION['profil']['login'] ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= URL ?>compte/tableau"><i class="fas fa-gauge-high"></i>Mon espace</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/projets"><i class="fas fa-diagram-project"></i>Mes projets</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/documents"><i class="fas fa-folder-open"></i>Mes documents</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/demandes"><i class="fas fa-comments"></i>Mes demandes</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/profil"><i class="fas fa-id-card"></i>Mon profil</a></li>
              <li><a class="dropdown-item" href="<?= URL ?>compte/deconnexion"><i class="fas fa-right-from-bracket"></i>Se déconnecter</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <li class="nav-item nav-cta ms-lg-2">
          <a href="<?= URL ?>contact" class="btn btn-gold btn-sm">Devis gratuit</a>
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
          <span class="eyebrow"><i class="fas fa-star"></i>95 % de clients satisfaits · France entière</span>
          <h1>Lancez et <span class="accent">développez</span> votre entreprise</h1>
          <p class="lead"><?= $hero_texte ?? "" ?></p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="#packs" class="btn btn-gold btn-lg">Découvrir nos packs</a>
            <a href="<?= URL ?>contact" class="btn btn-outline-light btn-lg">Devis gratuit</a>
          </div>
          <div class="hero-badges">
            <span><i class="fas fa-bolt"></i>Livraison 48h à 7 jours</span>
            <span><i class="fas fa-video"></i>Visio ou rendez-vous</span>
            <span><i class="fas fa-credit-card"></i>Paiement en 2x ou 3x</span>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
          <div class="hero-visual">
            <img class="hero-img" src="<?= URL ?>public/Assets/images/entreprise/brainstorming.png" alt="Entrepreneurs en réunion de lancement">
            <div class="hero-card card-a">
              <span class="icon"><i class="fas fa-file-signature"></i></span>
              <span><strong>Kbis obtenu</strong>Statuts, immatriculation, ACRE</span>
            </div>
            <div class="hero-card card-b card-cyan">
              <span class="icon"><i class="fas fa-chart-line"></i></span>
              <span><strong>+ de clients</strong>Site, SEO &amp; stratégie</span>
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
            <a href="<?= URL ?>contact" class="btn btn-gold">Devis gratuit</a>
            <a href="#tarifs" class="btn btn-outline-light">Voir les tarifs</a>
          </div>
          <?php if(!empty($hero_badges)) : ?>
            <div class="hero-badges">
              <?php foreach($hero_badges as $badge) : [$icone, $texte] = explode("|", $badge, 2); ?>
                <span><i class="fas <?= $icone ?>"></i><?= $texte ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
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
