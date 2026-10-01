<?php

    session_set_cookie_params([
      "httponly" => true,
      "samesite" => "Lax",
      "secure" => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off"
    ]);
    session_start();

    define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off" ? "https" : "http").  "://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

    require_once("./controllers/Toolbox.class.php");
    require_once("./controllers/securite.class.php");
    require_once("./controllers/Visiteur/Visiteur.controller.php");
    require_once("./controllers/Utilisateur/Utilisateur.controller.php");
    require_once("./controllers/Administrateur/Administrateur.controller.php");
    require_once("./controllers/SuperAdministrateur/SuperAdministrateur.controller.php");
    $visiteurController = new VisiteurController();
    $utilisateurController = new UtilisateurController();
    $administrateurController = new AdministrateurController();
    $sAdministrateurController = new SAdministrateurController();

    //recupere un champ POST nettoyé
    function post($cle){
      return isset($_POST[$cle]) ? trim((string)$_POST[$cle]) : "";
    }

    try {
      //decoupage de l'url
      $url = [];
      if(empty($_GET['page'])){
        $page = "accueils";
      } else {
        $url = explode("/", trim((string)$_GET['page'], "/"));
        $page = $url[0];
      }
      $url = array_pad($url, 3, "");

      //toutes les requetes POST doivent contenir le jeton anti-CSRF
      if($_SERVER['REQUEST_METHOD'] === "POST" && !Securite::verifierCsrf()){
        Toolbox::ajouterMessageAlerte("Votre session a expiré, merci de renvoyer le formulaire.", Toolbox::COULEUR_ROUGE);
        $retour = [
          "validation_login" => "login",
          "validation_creerCompte" => "creerCompte",
          "validation_contact" => "contact",
          "compte" => "compte/profil",
          "administration" => "administration/droits",
        ];
        Toolbox::redirection($retour[$page] ?? "accueils");
      }

      //routage vers les différentes pages
      switch($page){
        case "accueils": $visiteurController->accueil();
        break;
        case "prestations":
          switch($url[1]){
            case "": $visiteurController->accueil(); break;
            case "entreprises": $visiteurController->entreprise(); break;
            case "sites": $visiteurController->site(); break;
            case "reseaux": $visiteurController->reseaux(); break;
            case "marketing": $visiteurController->marketing(); break;
            default: throw new Exception("Cette prestation n'existe pas");
          }
        break;
        case "entreprises":
          switch ($url[1]){
            case "": $visiteurController->entreprise(); break;
            case "creation": $visiteurController->creation_entreprise(); break;
            case "modification": $visiteurController->modification_entreprise(); break;
            case "gestion": $visiteurController->gestion_entreprise(); break;
            default: throw new Exception("La page n'existe pas");
          }
        break;

        case "contact":
          $visiteurController->contact();
          break;
        case "validation_contact":
          //champ piège invisible : rempli uniquement par les robots
          if(post('site_web') !== ""){
            Toolbox::redirection("contact");
          }
          $visiteurController->validation_contact(post('nom'), post('mail'), post('message'), post('sujet'));
          break;
        case "login":
          $visiteurController->login();
          break;

        case "validation_login":
          if(post('login') !== "" && post('password') !== ""){
            $login = Securite::secureHTML(post('login'));
            $password = Securite::secureHTML($_POST['password']);
            $utilisateurController->validation_login($login, $password);
          }else{
            Toolbox::ajouterMessageAlerte("Login ou mot de passe non renseigné", Toolbox::COULEUR_ROUGE);
            Toolbox::redirection("login");
          }
        break;
        case "creerCompte":
          $visiteurController->creerCompte();
            break;
        case "validation_creerCompte":
          if (post('login') !== "" && post('password') !== "" && post('mail') !== ""){
            $login = Securite::secureHTML(post('login'));
            $password = Securite::secureHTML($_POST['password']);
            $mail = Securite::secureHTML(post('mail'));
            $utilisateurController->validation_creerCompte($login,$password,$mail);
          }else{
            Toolbox::ajouterMessageAlerte("Les 3 informations sont obligatoires !", Toolbox::COULEUR_ROUGE);
            Toolbox::redirection("creerCompte");
          }
        break;
        case "renvoyerMailValidation" :
          $utilisateurController->renvoyerMailValidation(Securite::secureHTML(rawurldecode($url[1])));
          break;
        case "validationMail":
          $utilisateurController->validation_mailCompte(Securite::secureHTML(rawurldecode($url[1])), $url[2]);
          break;
        case "compte" :
          if(!Securite::estConnecte()){
            Toolbox::ajouterMessageAlerte("Veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
            Toolbox::redirection("login");
          }
          switch($url[1]){
            case "profil" :
              $utilisateurController->profil();
              break;
            case "deconnexion" :
              $utilisateurController->deconnexion();
              break;
            case "validation_modificationMail" :
              $utilisateurController->validation_modificationMail(Securite::secureHTML(post('mail')));
              break;
            case "modificationPassword" :
              $utilisateurController->modificationPassword();
              break;
            case "validation_modificationPassword":
              if(post('ancienPassword') !== "" && post('nouveauPassword') !== "" && post('confirmNouveauPassword') !== ""){
                $ancienPassword = Securite::secureHTML($_POST['ancienPassword']);
                $nouveauPassword = Securite::secureHTML($_POST['nouveauPassword']);
                $confirmNouveauPassword = Securite::secureHTML($_POST['confirmNouveauPassword']);
                $utilisateurController->validation_modificationPassword($ancienPassword, $nouveauPassword,$confirmNouveauPassword);
              }else{
                Toolbox::ajouterMessageAlerte("Vous n'avez pas renseigné toutes les informations", Toolbox::COULEUR_ROUGE);
                Toolbox::redirection('compte/modificationPassword');
              }
              break;
            case "suppressionCompte":
              //la suppression ne se fait que via le formulaire (POST + jeton CSRF)
              if($_SERVER['REQUEST_METHOD'] !== "POST"){
                Toolbox::redirection("compte/profil");
              }
              $utilisateurController->validation_suppressionCompte();
              break;
            case "validation_modificationImage":
              //verifie si l'image existe et verifie sa taille.
              if (isset($_FILES['image']) && ($_FILES['image']['size'] > 0)) {
                $utilisateurController->validation_modificationImage($_FILES['image']);
              } else {
                Toolbox::ajouterMessageAlerte("Vous n'avez pas sélectionné d'image", Toolbox::COULEUR_ROUGE);
                Toolbox::redirection("compte/profil");
              }
              break;
            default:
              throw new Exception("La page n'existe pas");
          }
          break;
        case "administration":
          if(!Securite::estConnecte()){
            Toolbox::ajouterMessageAlerte("Veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
            Toolbox::redirection("login");
          }
          if (!Securite::estAdministrateur() && !Securite::estSuperAdministrateur()) {
            Toolbox::ajouterMessageAlerte("Vous n'avez pas le droit d'être ici", Toolbox::COULEUR_ROUGE);
            Toolbox::redirection("accueils");
          }
          switch($url[1]){
            case "droits":
              $administrateurController->gestion_droits();
              break;
            case "validation_modificationRole" :
              $administrateurController->validation_modificationRole(Securite::secureHTML(post('login')), post('role'));
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
            //pages reservees au super administrateur
            case "gestionFullUtilisateur":
            case "validationModificationFullUtilisateur":
              if(!Securite::estSuperAdministrateur()){
                Toolbox::ajouterMessageAlerte("Cette page est réservée au super administrateur", Toolbox::COULEUR_ROUGE);
                Toolbox::redirection("administration/droits");
              }
              if($url[1] === "gestionFullUtilisateur"){
                $sAdministrateurController->gestion_full_utilisateur();
              }else{
                $sAdministrateurController->validation_modification_full_utilisateur(
                  Securite::secureHTML(post('login')), Securite::secureHTML(post('mail')), post('role'), post('is_valid'));
              }
              break;
            default:
              throw new Exception("La page n'existe pas");
          }
        break;
        default:
          throw new Exception("La page demandée n'existe pas");
      }

    } catch (PDOException $e) {
      error_log($e->getMessage());
      $visiteurController->pageErreur("Le service est momentanément indisponible. Merci de réessayer plus tard.", 500);
    } catch (Exception $e) {
      $visiteurController->pageErreur($e->getMessage());
    }
