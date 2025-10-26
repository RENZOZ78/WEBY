<?php

    session_start();

    define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS'])? "https" : "http").  "://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

    require_once("./controllers/Visiteur/Visiteur.controller.php");
      require_once("./controllers/Utilisateur/Utilisateur.controller.php");
      require_once("./controllers/Toolbox.class.php");
      require_once ("./controllers/securite.class.php");
      require_once("./controllers/Administrateur/Administrateur.controller.php");
      require_once("./controllers/SuperAdministrateur/SuperAdministrateur.controller.php");
      $visiteurController = new VisiteurController();
      $utilisateurController = new UtilisateurController();
      $administrateurController = new AdministrateurController();
      $sAdministrateurController = new SAdministrateurController();


      try {
        //test routage
        if(empty($_GET['page'])){
           //echo "page d'accueil";
           //header("location:accueil");
            $page= "accueils";

        } else{
           //echo "autres pages";
           $url= explode("/", filter_var($_GET['page'],FILTER_SANITIZE_STRING));
           $page = $url[0];
        }

        //routage vers les différentes page_description
        switch($page){
          case "accueils": $visiteurController->accueil();
          break;
          case "prestations":
            if(empty($url[1])){
              // Si on est sur /prestations sans rien après, on peut rediriger vers l'accueil ou une page de résumé
              $visiteurController->accueil();
            } else {
              switch($url[1]){
                case "entreprises":
                  $visiteurController->entreprise();
                  break;
                case "sites":
                  $visiteurController->site();
                  break;
                case "reseaux":
                  $visiteurController->reseaux();
                  break;
                case "marketing":
                  $visiteurController->marketing();
                  break;
                default: throw new exception("Cette prestation n'existe pas");
              }
            }
          break;
          case "entreprises":
            if(empty($url[1])){
              $visiteurController->entreprise();
            } else {
          //$visiteurController->entreprise();
            switch ($url[1]){
                case "creation": 
                  $visiteurController->creation_entreprise();
                  break;
                case "modification": 
                  $visiteurController->modification_entreprise();
                  break;
                case "gestion": 
                  $visiteurController->gestion_entreprise();
                  break;          
            default: 
              throw new exception( "la page n'existe pas");
            }
          }
          break;

          case "contact":  
            $visiteurController->contact();
            break;
          case "login":  
            $visiteurController->login();
            break;

          case "validation_login":
            if(!empty ($_POST['login']) && !empty($_POST['password'])){
              $login = Securite::secureHTML($_POST['login']);
              $password = Securite::secureHTML($_POST['password']);
              $utilisateurController->validation_login($login, $password);
            }else{
              Toolbox::ajouterMessageAlerte("login ou mot de pass non renseignés", Toolbox::COULEUR_ROUGE);
              header('location: '.URL."login");
            }
          break;
          case "creerCompte": 
            $visiteurController->creerCompte();
              break;
          case "validation_creerCompte":
            if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'])){
                echo "les champs sont remplis";
              $login = Securite::secureHTML($_POST['login']);
              $password = Securite::secureHTML($_POST['password']);
              $mail = Securite::secureHTML($_POST['mail']);
              $utilisateurController->validation_creerCompte($login,$password,$mail);
            }else{
              Toolbox::ajouterMessageAlerte("Les 3 informations sont obligatoires !", Toolbox::COULEUR_ROUGE);
              header("location:".URL."creerCompte");
            }
          break;
          case "renvoyerMailValidation" : 
            $utilisateurController->renvoyerMailValidation($url[1]);
            break;
          case "validationMail": 
            $utilisateurController->validation_mailCompte($url[1],$url[2]);
            break;
          case "compte" :
            if(!Securite::estConnecte()){
              Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
              header("location: ".URL."login");
            }else{
              switch($url[1]){
                case "profil" : 
                  $utilisateurController->profil();
                  break;
                case "deconnexion" : 
                  $utilisateurController->deconnexion();
                  break;
                case "validation_modificationMail" : 
                  $utilisateurController->validation_modificationMail(Securite::secureHTML($_POST['mail']));
                  break;
                case "modificationPassword" : 
                  $utilisateurController->modificationPassword();
                  break;
                case "validation_modificationPassword":
                if( !empty($_POST['ancienPassword']) && !empty($_POST['nouveauPassword']) && !empty($_POST['confirmNouveauPassword'])){
                  $ancienPassword =Securite::secureHTML($_POST['ancienPassword']);
                  $nouveauPassword =Securite::secureHTML($_POST['nouveauPassword']);
                  $confirmNouveauPassword =Securite::secureHTML($_POST['confirmNouveauPassword']);
                  $utilisateurController->validation_modificationPassword($ancienPassword, $nouveauPassword,$confirmNouveauPassword);
                }else{
                  Toolbox::ajouterMessageAlerte("Vous n'avez pas renseigné toutes les informations", Toolbox::COULEUR_ROUGE);
                  header('Location: '.URL. 'compte/modificationPassword');
                }
                break;
                case "suppressionCompte": $utilisateurController->validation_suppressionCompte();
                  break;
                case "validation_modificationImage":
                  //print_r($_FILES['image']);
                  //verifie si l'image existe et verifie sa taille.
                  if (isset($_FILES['image']) && ($_FILES['image']['size'] > 0)) {
                    $utilisateurController->validation_modificationImage($_FILES['image']);
                  } else {
                    Toolbox::ajouterMessageAlerte("vous n'avez pas modifié l'image", Toolbox ::COULEUR_ROUGE);
                    header("location: " . URL . "compte/profil");
                  }
                  break;
                default: 
                  throw new exception( "la page n'existe pas");
                }
              }
            break;
          case "administration":
            if(!Securite::estConnecte()){
              Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
              header("location: ".URL."Login");
            } elseif (!Securite::estAdministrateur() && !Securite::estSuperAdministrateur()) {
              Toolbox::ajouterMessageAlerte("Vous n'avez pas le droit d'être ici ", Toolbox::COULEUR_ROUGE);
              header("location: ".URL."accueil");
            }elseif (Securite::estAdministrateur()){
              switch($url[1]){
                case "droits": 
                  $administrateurController->gestion_droits();
                  break;
                case "validation_modificationRole" : 
                  $administrateurController->validation_modificationRole($_POST['login'], $_POST['role']);
                  break;
                case "gestionCommandes": 
                  $administrateurController->gestion_commandes();
                  break;
                case "gestionProduits": 
                  $administrateurController->gestion_produits();
                  break;
                case "gestionUtilisateurs": 
                  $administrateurController->gestion_utilisateur();
                  break;
                default:
                  throw new Exception("La page n'existe pas");
              }

            }elseif (Securite::estSuperAdministrateur()){
              switch($url[1]){
                case "droits": 
                  $administrateurController->gestion_droits();
                  break;
                case "validation_modificationRole" : 
                  $administrateurController->validation_modificationRole($_POST['login'], $_POST['role']);
                  break;
                case "gestionCommandes": 
                  $administrateurController->gestion_commandes();
                  break;
                case "gestionProduits": 
                  $administrateurController->gestion_produits();
                  break;
                case "gestionFullUtilisateur":  
                  $sAdministrateurController->gestion_full_utilisateur();
                  break;
                case "validationModificationFullUtilisateur" : 
                  $sAdministrateurController->validation_modification_full_utilisateur($_POST['login'], $_POST['mail'], $_POST['role'], $_POST['is_valid'], $_POST['role']);
                  break;

                default :   
                  throw new Exception("La page n'existe pas");
              }
            }
          break;
          default: 
            throw new exception( "la page n'existe pas du tout");
        }

      } catch (Exception $e) {
        $visiteurController->pageErreur($e->getMessage());
      }




     ?>