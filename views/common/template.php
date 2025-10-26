<!DOCTYPE html>
<html lang="fr">

  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="<?= $page_description; ?>">


      <!--le css de bootstrap-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
      <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.0/dist/bootstrap-table.min.css">

      <!--Custom css-->
      <link  href="<?= URL; ?>public/CSS/style.css" rel="stylesheet"/>
       <?php if(!empty($custom_css)) : ?>
         <?php foreach($custom_css as $no_css ) : ?>
           <link  href="<?= URL; ?>public/CSS/<?= $no_css ?>" rel="stylesheet"/>
         <?php endforeach; ?>
      <?php endif; ?>

      <!-- favicon -->
      <link rel="shortcut icon" type="image/png" href="<?= URL; ?>/img/favicon.png"/>

      <!--Police de caractère-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

      <!--fontawesome-->
      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

      <!-- css ekko librairie -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">

      <!-- css aos librairie -->
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

      <link  href="<?= URL; ?>public/CSS/custom.css" rel="stylesheet"/>

      <title><?= $page_title; ?></title>
  </head>

  <body>

      <!-- afficher le header (barre de nav + texte intro)-->
      <?php require_once("inc/header.php"); ?>

      <!-- affichage des alertes optimisés-->
      <div class="container mt-sm-5" >
          <?php
          if(!empty($_SESSION['alert'])) {
              foreach($_SESSION['alert'] as $alert){
                  echo "<div class='alert ". $alert['type'] ."' role='alert'> ".$alert['message']."
              </div>";
              }
              unset($_SESSION['alert']);
          }

          ?>
      </div>


      <!-- affichage du contenu ------------------------------>
         <?= $page_content; ?>

      <!-- footer ----------------------------------------->
      <?php
          include "./inc/footer.php";
      ?>

     <!-- Scripts -------------------------------------->
        <!-- js bootstrap -->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>

        <!-- cdn boostrap menu hamburger -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-table@1.22.0/dist/bootstrap-table.min.js"></script>


        <!-- js ekko -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script src="app.js"></script>
    <!-- aos-librarie -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

    <!--    js optimisé-->
      <link  href="<?= URL; ?>public/Javascript/accueil.js" rel="stylesheet"/>
      <?php if(!empty($page_js)) : ?>
          <?php foreach($page_js as $fichier_js ) : ?>
              <script src="<?= URL?>public/Javascript/<?= $fichier_js ?>"></script>
          <?php endforeach; ?>
      <?php endif; ?>


  </body>
</html>