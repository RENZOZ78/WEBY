<!-- header, Navigation, titre ---------------------------------------->

<header id="top"  >
  <div class="img_top">

        <div class="container ">
          <nav class="navbar navbar-expand-md bg-primary navbar-dark fixed-top" id="main-nav">

            <div class="container cont_nav">
              <!-- <iframe src="public\Assets\images\accueil\logo_aigle.svg"
              width="100" height="100" style="border:1;"></iframe> -->

              <object type="image/svg+xml" class="logo_aigle" data="..\public\Assets\images\accueil\logo_aigle.svg"
              width="100" height="100" ></object>

              <a href="<?= URL; ?>accueils" class="navbar-brand">WebyCloudy</a>

              <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarCollapse">
                                <ul class="navbar-nav ml-auto">
                
                                  <li class="nav-item mr-1">
                                    <a href="<?= URL; ?>accueils" class="nav-link">Accueil</a>
                                  </li>
                
                                  <!-- deroulant prestations ------------------->
                                  <a href="#" id="navbarDropdown" aria-expanded="false" data-toggle="dropdown" class="nav-link dropdown-toggle dropdown-toggle">Prestations</a>
                                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li class="nav-item mr-1">
                                      <a href="<?= URL; ?>prestations/entreprises" class="nav-link">Société</a>
                                    </li>
                
                                    <li class="nav-item mr-1">
                                      <a href="<?= URL; ?>prestations/sites" class="nav-link">Site internet</a>
                                    </li>
                
                                    <li class="nav-item mr-1">
                                      <a href="<?= URL; ?>prestations/reseaux" class="nav-link">Réseaux sociaux</a>
                                    </li>
                
                                    <li class="nav-item mr-1">
                                      <a href="<?= URL; ?>prestations/marketing" class="nav-link">Publicité</a>
                                    </li>
                                  </ul>
                
                                  <li class="nav-item mr-1">
                                    <a href="<?= URL; ?>contact" class="nav-link">Contact</a>
                                  </li>
                
                                  <!-- si l'utilisateur n'est pas connecté --------------->
                                  <?php if(!Securite::estConnecte()) : ?>
                                    <li class="nav-item mr-1">
                                      <a
                                      href="#"
                                      id="navbarDropdown" aria-expanded="false" data-toggle="dropdown" class="nav-link dropdown-toggle dropdown-toggle">Votre compte</a>
                                      <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="<?= URL; ?>login">Se connecter</a></li>
                                        <li><a class="dropdown-item" href="<?= URL; ?>creerCompte">Créer compte</a></li>
                                      </ul>
                                    </li>
                
                
                
                                <!-- si l'utilisateur est connecté ------------------->
                              <?php elseif(Securite::estConnecte()) : ?>
                                <li class="nav-item mr-1">
                                  <a href="#" id="navbarDropdown" aria-expanded="false" data-toggle="dropdown" class="nav-link dropdown-toggle dropdown-toggle">Compte</a>
                                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="<?= URL; ?>compte/profil">Profil</a></li>
                                    <li><a class="dropdown-item" href="<?= URL; ?>compte/deconnexion">Se deconnecter</a></li>
                                  </ul>
                                </li>
                              <?php endif; ?>
                
                              <!-- si l'uilitisateur est admin, il a access a l'onglet admnistration, gestio commande, gestion produits -->
                              <?php if(Securite::estConnecte() && Securite::estAdministrateur()  ) : ?>
                                <li class=" dropdown">
                                  <button class="btn btn-secondary nav-link dropdown-toggle" type="button" href="#"   aria-expanded="false" data-toggle="dropdown" >Administration</button>
                                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?= URL; ?>administration/droits">Gérer les droits</a></li>
                                    <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionCommandes">Gestion commandes</a></li>
                                    <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionProduits">Gestion produits</a></li>
                                  </ul>
                                </li>
                
                                <!-- si l'uilitisateur est superAdmin, il a access a la page gesdtion utilisateur et gestio commande et gestion produit -->
                              <?php elseif( Securite::estConnecte() &&  Securite::estSuperAdministrateur())
                                :?>
                                <li class="dropdown">
                                  <button class="btn btn-secondary nav-link dropdown-toggle" type="button" href="#"   aria-expanded="false" data-toggle="dropdown" >Super Administration</button>
                                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionFullUtilisateur">Gestion utilisateur</a></li>
                                    <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionCommandes">Gestion commandes</a></li>
                                    <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionProduits">Gestion produits</a></li>
                                  </ul>
                                </li>
                              <?php endif; ?>
                
                                </ul>          </div>
        </div>
      </nav>

      <div class="text-intro">
        <div class="preTxt font-italic"><?= $uvp; ?></div>
        <h1><?= $H1; ?></h1>
        <!-- <a href="<?= URL; ?>index.php" class=" btn btn_nav btn-dark mt-3">En savoir Plus</a>
        <a href="<?= URL; ?>projets.php" class=" btn btn_nav btn-outline-dark mt-3">Nos projets</a> -->
      </div>
    </div>

  </div>
</header>
