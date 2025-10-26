<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/MainManager.model.php");
  require_once("models/Utilisateur/Utilisateur.model.php");

  class UtilisateurController extends MainController{

    private $utilisateurManager;

    //constructeur pour creer une instance de MainManager
    public function __construct(){
      $this->utilisateurManager = new UtilisateurManager();
    }

    //ft qui verifie si les data login sont valides + validaiton mail
    public function validation_login($login, $password){
      if($this->utilisateurManager->isCombinaisonValide($login, $password)){
          if($this->utilisateurManager->estCompteActive($login)){
            Toolbox::ajouterMessageAlerte("Bon retour sur le site ".$login. "!", Toolbox:: COULEUR_VERTE);
            $_SESSION['profil'] = ["login" => $login];
              header("location: ".URL."compte/profil");
              exit();
          }else{
            $msg =  "Le compte de ".$login. " n'a pas été activé par mail. ";
            $msg .= "<a href='renvoyerMailValidation/".$login."'>Renvoyez le mail de validation </a>";
            Toolbox::ajouterMessageAlerte($msg, Toolbox::COULEUR_ROUGE);
            //renvoyer le mail da validation a l'utilisateur
            header("Location: ".URL."login");
            exit();
          }
      }else {
        Toolbox::ajouterMessageAlerte("la combinaison mot de passe et login non valide", Toolbox::COULEUR_ROUGE);
        header("location: ".URL. "login");
        exit();
      }
    }

    //ft page profil----------------
    public function profil(){
    $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
    $_SESSION['profil']['role'] = $datas['role'];

      $data_page = [
        "view" => "views/Utilisateur/profil.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Mon Profil",
        "uvp"=> "Gérez vos informations personnelles et vos préférences.",
        "utilisateur" => $datas,
        "page_js" => ['profil.js'],
        "page_title"=> "WebyCloudy | Profil",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
  }

    //ft page deconexion----------------
    public function deconnexion(){
    Toolbox::ajouterMessageAlerte("Vous êtes maintenant déconnecté", Toolbox::COULEUR_ORANGE);
    unset($_SESSION['profil']);
    header ("location: " .URL."accueils");
    exit();
  }

    //ft qui valide un compte , en verifiant que le login n'existe pas
    public function validation_creerCompte($login,$password,$mail){
      if ($this->utilisateurManager->verifLoginDisponible($login)){
        $passwordCrypte = password_hash($password,PASSWORD_DEFAULT);
        $clef = rand(0,9999);
        if($this->utilisateurManager->bdCreerCompte($login,$passwordCrypte,$mail,$clef,"profils/profil.png","utilisateur")){
          $this->sendMailValidation($login, $mail, $clef);
          echo "instance avec ". $login,$mail,$clef. "crée!!";
          Toolbox::ajouterMessageAlerte("La compte a été crée, un mail de validation vous sera envoyé", Toolbox::COULEUR_VERTE);
          header("Location: ".URL. "login");
          echo "le compte est crée";
          exit();
        }
      }else{
        Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
        header("Location: ".URL."creerCompte");
        echo "le compte n'est pas crée";
        exit();
      }
    }

    //ft  qui valide l'envoie de mailde  validation_login
    private function sendMailValidation($login,$mail,$clef){
      $urlVerification = URL."validationMail/".$login."/".$clef;
      $sujet = "Creation du compte sur le site webycloudy";
      $message = "Pour valider votre compte veuillez cliquer sur le lien suivant".$urlVerification;
      Toolbox::sendMail($mail,$sujet,$message);
    }

    public function renvoyerMailValidation($login){
      $utilisateur = $this->utilisateurManager->getUserInformation($login);
      $this->sendMailValidation($login,$utilisateur['mail'],$utilisateur['clef']);
      header ("Location: ".URL."login");
      exit();
    }

    //ft qui active le compte utilisateur=basculer le champs isValid a 1
    public function validation_mailCompte($login,$clef){
      if($this->utilisateurManager->bdValidationMailCompte($login,$clef)){
        Toolbox::ajouterMessageAlerte("Votre compte est bien activéé !", Toolbox::COULEUR_VERTE);
        $_SESSION['profil'] = [
          "login" => $login,
        ];
        header("Location: ".URL.'compte/profil');
        exit();
      }else{
        Toolbox::ajouterMessageAlerte("Le compte n'a pas été activée!", Toolbox::COULEUR_ROUGE);
        header ("Location :".URL."creerCompte");
        exit();
      }
    }

    //ft qui modifie le mail
    public function validation_modificationMail($mail){
      if (!isset($_SESSION['profil'])) {
        Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
        header("location: ".URL."login");
        exit();
      }
      //echo "entree";
      if($this->utilisateurManager->bdValidationModificationMail($_SESSION['profil']['login'],$mail)){
        Toolbox::ajouterMessageAlerte("Le mail est bien modifié !", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Aucune modification de mail effectuée !", Toolbox::COULEUR_ROUGE);
      }
        header ("Location: ".URL."compte/profil");
        exit();
    }

    public function modificationPassword(){
      if (!isset($_SESSION['profil'])) {
        Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
        header("location: ".URL."login");
        exit();
      }
        $data_page = [
          "view" => "./views/Utilisateur/modificationPassword.view.php",
          "custom_css" => ["style.css", "accueil.css"],
          "H1" => "Changer de Mot de Passe",
          "uvp"=> "Pour votre sécurité, choisissez un mot de passe fort.",
          "page_js" => ["modificationPassword.js"],
          "page_title"=> "WebyCloudy | Modification Mot de passe",
          "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
      }

    public function validation_modificationPassword($ancienPassword,$nouveauPassword,$confirmNouveauPassword){
      if (!isset($_SESSION['profil'])) {
        Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
        header("location: ".URL."login");
        exit();
    }
      if($nouveauPassword === $confirmNouveauPassword){

        if($this->utilisateurManager->isCombinaisonValide($_SESSION['profil']['login'],$ancienPassword)){
          $passwordCrypte = password_hash($nouveauPassword,PASSWORD_DEFAULT);

            if($this->utilisateurManager->bdModificationPassword($_SESSION['profil']['login'],$passwordCrypte)){
              Toolbox::ajouterMessageAlerte('Le mot de passe a bien été modifié', Toolbox::COULEUR_VERTE);
              header("Location: ".URL."compte/profil");
              exit();
            }else{
              Toolbox::ajouterMessageAlerte("La modification n'a pas été éffectuée", Toolbox::COULEUR_ROUGE );
              header("Location: ".URL."compte/modificationPassword");
              exit();
            }

        }else{
          Toolbox::ajouterMessageAlerte('La combinaison login /ancien mot de passe ne correspond pas', Toolbox::COULEUR_ROUGE);
          header('Location :'.URL.'compte/modificationPassword');
          exit();
        }

      }else{
        Toolbox::ajouterMessageAlerte('Les deux 2 nouveaux mots de passe ne correpondent pas', Toolbox::COULEUR_ROUGE);
        header ('Location :'.URL.'compte/modificationPassword');
        exit();
      }
    }

    //ft qui valdie la suppression du compte
    public function validation_suppressionCompte(){
      if (!isset($_SESSION['profil'])) {
        Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
        header("location: ".URL."login");
        exit();
      }
        //Suppression de l'image
        $this->dossierSuppressionImageUtilisateur($_SESSION['profil']['login']);
        //Suppression du dossier
        rmdir("public/Assets/images/profils/".$_SESSION['profil']['login']);
      if($this->utilisateurManager->bdSuppressionCompte($_SESSION['profil']['login'])){
        Toolbox::ajouterMessageAlerte('La suppression du compte est effectué!', Toolbox::COULEUR_VERTE);
        $this->deconnexion();
      }
      else{
        Toolbox::ajouterMessageAlerte("La suppression du compte n'a pas été effectuée, contacté l'utilisateur", Toolbox::COULEUR_ROUGE);
        header ("location: ".URL."compte/profil");
        exit();
      }
    }


    /**
    *Ft qui gere l'ajout de la nouvelle image de profil
     * suppression de l'ancienne images
     * ajout de nouvelles images dans le repertoire
     */
    public function validation_modificationImage($file){
      if (!isset($_SESSION['profil'])) {
        Toolbox::ajouterMessageAlerte("Veuillez vous connecter!", Toolbox::COULEUR_ROUGE);
        header("location: ".URL."login");
        exit();
      }
      try {
        $repertoire = "public/Assets/images/profils/".$_SESSION['profil']['login']."/";
        //Ajout image dans le repertoire
        $nomImage = Toolbox::ajoutImage($file, $repertoire);
        //Supression de l'ancienne images
        $this->dossierSuppressionImageUtilisateur($_SESSION['profil']['login']);
        //Ajout de la nouvelle image dans la bdd
        $nomImageBD = "profils/".$_SESSION['profil']['login']."/".$nomImage;
        if($this->utilisateurManager->bdAjoutImage($_SESSION['profil']['login'],$nomImageBD)){
          Toolbox::ajouterMessageAlerte("La modification a été éffectuée", Toolbox::COULEUR_VERTE);
        }else{
            Toolbox::ajouterMessageAlerte("La modification de l'image n'a pas été effectuée", Toolbox::COULEUR_ROUGE);
        }
      } catch (\Exception $e) {
        Toolbox::ajouterMessageAlerte($e->getMessage(), Toolbox::COULEUR_ROUGE);
      }
      header("Location: ".URL."compte/profil");
    }

    //ft private Suppression de l'ancienne image
    private function dossierSuppressionImageUtilisateur(){
      $ancienneImage = $this->utilisateurManager->getImageUtilisateur($_SESSION['profil']['login']);
      if($ancienneImage !== "profils/profil.png"){
        unlink("public/Assets/images/".$ancienneImage);
      }
    }

    //ft page erreur qui appelle la ft du parent-------
    //on ne veut pas de page erreur specifique aux visiteur => on laisse la ft principale dans le controlller
    public function pageErreur($msg){
      parent::pageErreur($msg);
    }

  }
 ?>
