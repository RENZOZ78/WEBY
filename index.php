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
    require_once("./models/Installation.class.php");
    require_once("./controllers/Visiteur/Visiteur.controller.php");
    require_once("./controllers/Utilisateur/Utilisateur.controller.php");
    require_once("./controllers/Utilisateur/Espace.controller.php");
    require_once("./controllers/Administrateur/Administrateur.controller.php");
    require_once("./controllers/SuperAdministrateur/SuperAdministrateur.controller.php");
    $visiteurController = new VisiteurController();
    $utilisateurController = new UtilisateurController();
    $espaceController = new EspaceController();
    $administrateurController = new AdministrateurController();
    $sAdministrateurController = new SAdministrateurController();

    //recupere un champ POST nettoyé
    function post($cle){
      return isset($_POST[$cle]) ? trim((string)$_POST[$cle]) : "";
    }

    //champ POST texte libre (echappe, sauts de ligne conserves)
    function postTexte($cle){
      return Securite::secureHTML(post($cle));
    }

    //redirection permanente (anciennes adresses)
    function redirectionPermanente($chemin){
      header("Location: ".URL.$chemin, true, 301);
      exit();
    }

    try {
      //premier lancement : creation des tables et du compte administrateur
      Installation::verifier();

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
          "compte" => "compte/tableau",
          "administration" => "administration/tableau",
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
            case "lancement": $visiteurController->lancement(); break;
            case "gestion": $visiteurController->gestion(); break;
            case "sites": $visiteurController->site(); break;
            case "marketing": $visiteurController->marketing(); break;
            //anciennes adresses
            case "entreprises": redirectionPermanente("prestations/lancement"); break;
            case "reseaux": redirectionPermanente("prestations/marketing"); break;
            default: throw new Exception("Cette prestation n'existe pas");
          }
        break;
        case "entreprises":
          redirectionPermanente($url[1] === "gestion" ? "prestations/gestion" : "prestations/lancement");
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
            case "":
            case "tableau":
              $espaceController->tableau();
              break;
            case "projets":
              $espaceController->projets();
              break;
            case "projet":
              $espaceController->projet((int)$url[2]);
              break;
            case "documents":
              $espaceController->documents();
              break;
            case "document":
              $espaceController->document((int)$url[2]);
              break;
            case "demandes":
              $espaceController->demandes();
              break;
            case "demande":
              $espaceController->demande((int)$url[2]);
              break;
            case "nouvelleDemande":
              $espaceController->nouvelleDemande();
              break;
            case "validation_nouvelleDemande":
              $espaceController->validation_nouvelleDemande(postTexte('sujet'), postTexte('message'));
              break;
            case "validation_message":
              $espaceController->validation_message((int)post('demande_id'), postTexte('message'));
              break;
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
            case "":
            case "tableau":
              $administrateurController->tableau();
              break;
            case "projets":
              $administrateurController->projets();
              break;
            case "nouveauProjet":
              $administrateurController->nouveauProjet();
              break;
            case "validation_nouveauProjet":
              $administrateurController->validation_nouveauProjet(Securite::secureHTML(post('login')), postTexte('titre'), post('type'), post('etape'), postTexte('note'));
              break;
            case "projet":
              $administrateurController->projet((int)$url[2]);
              break;
            case "validation_projet":
              $administrateurController->validation_projet((int)post('projet_id'), Securite::secureHTML(post('login')), postTexte('titre'), post('type'), post('etape'), postTexte('note'));
              break;
            case "suppression_projet":
              if($_SERVER['REQUEST_METHOD'] !== "POST") Toolbox::redirection("administration/projets");
              $administrateurController->suppression_projet((int)post('projet_id'));
              break;
            case "validation_document":
              $administrateurController->validation_document((int)post('projet_id'), $_FILES['document'] ?? [], postTexte('nom'), post('categorie'));
              break;
            case "suppression_document":
              if($_SERVER['REQUEST_METHOD'] !== "POST") Toolbox::redirection("administration/projets");
              $administrateurController->suppression_document((int)post('document_id'));
              break;
            case "document":
              $administrateurController->document((int)$url[2]);
              break;
            case "demandes":
              $administrateurController->demandes();
              break;
            case "demande":
              $administrateurController->demande((int)$url[2]);
              break;
            case "validation_reponse":
              $administrateurController->validation_reponse((int)post('demande_id'), postTexte('message'));
              break;
            case "validation_statutDemande":
              $administrateurController->validation_statutDemande((int)post('demande_id'), post('statut'));
              break;
            case "droits":
              $administrateurController->gestion_droits();
              break;
            case "validation_modificationRole" :
              $administrateurController->validation_modificationRole(Securite::secureHTML(post('login')), post('role'));
              break;
            case "gestionUtilisateurs":
              $administrateurController->gestion_utilisateur();
              break;
            //pages reservees au super administrateur
            case "gestionFullUtilisateur":
            case "validationModificationFullUtilisateur":
              if(!Securite::estSuperAdministrateur()){
                Toolbox::ajouterMessageAlerte("Cette page est réservée au super administrateur", Toolbox::COULEUR_ROUGE);
                Toolbox::redirection("administration/tableau");
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
