<?php
  $site = require("config/config.php");
  $page_description = $page_description ?? "WebyCloudy, agence web : création de société, sites internet, réseaux sociaux et marketing digital.";
  $custom_css = $custom_css ?? [];
  $page_js = $page_js ?? [];
  $page_courante = trim($_GET['page'] ?? "accueils", "/");
  //referencement : pages privees, formulaires de compte et erreurs exclus de Google ; les autres declarent leur adresse officielle
  $page_privee = in_array(explode("/", $page_courante)[0], ["login", "creerCompte", "compte", "administration", "supervision", "renvoyerMailValidation", "validationMail"], true);
  $page_noindex = $page_privee || http_response_code() >= 400;
  $page_canonique = rtrim($site['site_url'], "/")."/".(in_array($page_courante, ["", "accueils"], true) ? "" : $page_courante);
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <meta name="theme-color" content="#070d1f">
    <?php if($page_noindex) : ?>
      <meta name="robots" content="noindex">
    <?php else : ?>
      <link rel="canonical" href="<?= htmlspecialchars($page_canonique) ?>">
    <?php endif; ?>
    <title><?= htmlspecialchars(trim($page_title)) ?></title>

    <link rel="icon" type="image/png" href="<?= URL ?>img/favicon.png">

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3, Font Awesome 6, AOS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Thème du site -->
    <?php $version = function($fichier){ return is_file($fichier) ? "?v=".filemtime($fichier) : ""; }; //change a chaque mise en ligne : evite les anciens fichiers en cache ?>
    <link href="<?= URL ?>public/CSS/theme.css<?= $version("public/CSS/theme.css") ?>" rel="stylesheet">
    <?php foreach($custom_css as $no_css) : ?>
      <link href="<?= URL ?>public/CSS/<?= $no_css ?><?= $version("public/CSS/".$no_css) ?>" rel="stylesheet">
    <?php endforeach; ?>
  </head>

  <body>
    <a class="skip-link" href="#contenu">Aller au contenu</a>
    <div class="scroll-progress" aria-hidden="true"></div>

    <?php require_once("inc/header.php"); ?>

    <main id="contenu">
      <!-- affichage des alertes -->
      <?php if(!empty($_SESSION['alert'])) : ?>
        <div class="container flash-zone">
          <?php foreach($_SESSION['alert'] as $alert) : ?>
            <div class="alert <?= $alert['type'] ?> alert-dismissible fade show" role="alert">
              <?= $alert['message'] ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
          <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['alert']); ?>
      <?php endif; ?>

      <?= $page_content ?>
    </main>

    <?php require_once("inc/footer.php"); ?>

    <button class="back-top" type="button" aria-label="Revenir en haut de la page"><i class="fas fa-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="<?= URL ?>public/Javascript/main.js<?= $version("public/Javascript/main.js") ?>"></script>
    <?php foreach($page_js as $fichier_js) : ?>
      <script src="<?= URL ?>public/Javascript/<?= $fichier_js ?><?= $version("public/Javascript/".$fichier_js) ?>"></script>
    <?php endforeach; ?>
  </body>
</html>
