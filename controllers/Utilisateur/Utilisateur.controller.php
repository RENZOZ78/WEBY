<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/Utilisateur/Utilisateur.model.php");
  require_once("models/Espace/Espace.model.php");

  class UtilisateurController extends MainController{

    private $utilisateurManager;
    private $espaceManager;

    //constructeur pour creer une instance de UtilisateurManager
    public function __construct(){
      $this->utilisateurManager = new UtilisateurManager();
      $this->espaceManager = new EspaceManager();
    }

    //ft qui ouvre la session de l'utilisateur
    private function connecter($login){
      session_regenerate_id(true);
      $utilisateur = $this->utilisateurManager->getUserInformation($login);
      $_SESSION['profil'] = [
        "login" => $login,
        "role" => $utilisateur['role'] ?? "utilisateur"
      ];
    }

    //ft qui verifie si les data login sont valides + validaiton mail
    public function validation_login($login, $password){
      if($this->utilisateurManager->isCombinaisonValide($login, $password)){
          if($this->utilisateurManager->estCompteActive($login)){
            $this->connecter($login);
            Toolbox::ajouterMessageAlerte("Bon retour sur le site ".$login." !", Toolbox::COULEUR_VERTE);
            Toolbox::redirection(Securite::estAdministrateur() || Securite::estSuperAdministrateur() ? "administration/tableau" : "compte/tableau");
          }else{
            $msg =  "Le compte de ".$login." n'a pas été activé par mail. ";
            $msg .= "<a href='".URL."renvoyerMailValidation/".rawurlencode($login)."'>Renvoyer le mail de validation</a>";
            Toolbox::ajouterMessageAlerte($msg, Toolbox::COULEUR_ROUGE);
            Toolbox::redirection("login");
          }
      }else {
        Toolbox::ajouterMessageAlerte("La combinaison login / mot de passe n'est pas valide", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("login");
      }
    }

    //ft page profil----------------
    public function profil(){
      $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
      if(!$datas){
        $this->deconnexion();
      }
      $_SESSION['profil']['role'] = $datas['role'];

      $data_page = [
        "view" => "views/Utilisateur/profil.view.php",
        "custom_css" => [],
        "H1" => "Mon profil",
        "uvp"=> "Gérez vos informations personnelles et vos préférences.",
        "page_description" => "Page de profil",
        "utilisateur" => $datas,
        "page_js" => ['profil.js'],
        "page_title"=> "WebyCloudy | Profil",
        "hero_compact" => true,
        "espace" => "client",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    //ft page deconexion----------------
    public function deconnexion(){
      unset($_SESSION['profil']);
      session_regenerate_id(true);
      Toolbox::ajouterMessageAlerte("Vous êtes maintenant déconnecté", Toolbox::COULEUR_ORANGE);
      Toolbox::redirection("accueils");
    }

    //ft qui valide un compte , en verifiant que le login n'existe pas
    public function validation_creerCompte($login,$password,$mail){
      if(!filter_var(html_entity_decode($mail), FILTER_VALIDATE_EMAIL)){
        Toolbox::ajouterMessageAlerte("L'adresse mail n'est pas valide.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("creerCompte");
      }
      if(strlen($password) < 8){
        Toolbox::ajouterMessageAlerte("Le mot de passe doit contenir au moins 8 caractères.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("creerCompte");
      }
      if (!$this->utilisateurManager->verifLoginDisponible($login)){
        Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("creerCompte");
      }
      $passwordCrypte = password_hash($password,PASSWORD_DEFAULT);
      $clef = random_int(10000000, 2147483647);
      if($this->utilisateurManager->bdCreerCompte($login,$passwordCrypte,$mail,$clef,"profils/profil.png","utilisateur")){
        $this->sendMailValidation($login, $mail, $clef);
        Toolbox::ajouterMessageAlerte("Le compte a été créé, un mail de validation vous a été envoyé", Toolbox::COULEUR_VERTE);
        Toolbox::redirection("login");
      }
      Toolbox::ajouterMessageAlerte("La création du compte a échoué.", Toolbox::COULEUR_ROUGE);
      Toolbox::redirection("creerCompte");
    }

    //ft  qui valide l'envoie de mailde  validation_login
    private function sendMailValidation($login,$mail,$clef){
      $urlVerification = URL."validationMail/".rawurlencode($login)."/".$clef;
      $sujet = "Création du compte sur le site WebyCloudy";
      $message = "Bonjour ".html_entity_decode($login).",\n\nPour valider votre compte, veuillez cliquer sur le lien suivant :\n".$urlVerification."\n\nL'équipe WebyCloudy";
      Toolbox::sendMail(html_entity_decode($mail),$sujet,$message);
    }

    public function renvoyerMailValidation($login){
      $utilisateur = $this->utilisateurManager->getUserInformation($login);
      if($utilisateur && (int)$utilisateur['is_valid'] === 0){
        $this->sendMailValidation($login,$utilisateur['mail'],$utilisateur['clef']);
      }else{
        Toolbox::ajouterMessageAlerte("Aucun compte en attente de validation pour ce login.", Toolbox::COULEUR_ORANGE);
      }
      Toolbox::redirection("login");
    }

    //ft qui active le compte utilisateur=basculer le champs isValid a 1
    public function validation_mailCompte($login,$clef){
      if($login !== "" && ctype_digit((string)$clef) && $this->utilisateurManager->bdValidationMailCompte($login,$clef)){
        $this->connecter($login);
        Toolbox::ajouterMessageAlerte("Votre compte est bien activé !", Toolbox::COULEUR_VERTE);
        Toolbox::redirection("compte/tableau");
      }
      Toolbox::ajouterMessageAlerte("Le compte n'a pas été activé : lien invalide ou compte déjà actif.", Toolbox::COULEUR_ROUGE);
      Toolbox::redirection("login");
    }

    //ft qui modifie le mail
    public function validation_modificationMail($mail){
      if(!filter_var(html_entity_decode($mail), FILTER_VALIDATE_EMAIL)){
        Toolbox::ajouterMessageAlerte("L'adresse mail n'est pas valide.", Toolbox::COULEUR_ROUGE);
      }elseif($this->utilisateurManager->bdValidationModificationMail($_SESSION['profil']['login'],$mail)){
        Toolbox::ajouterMessageAlerte("Le mail est bien modifié !", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Aucune modification de mail effectuée !", Toolbox::COULEUR_ORANGE);
      }
      Toolbox::redirection("compte/profil");
    }

    public function modificationPassword(){
        $data_page = [
          "view" => "./views/Utilisateur/modificationPassword.view.php",
          "custom_css" => [],
          "H1" => "Changer de mot de passe",
          "uvp"=> "Pour votre sécurité, choisissez un mot de passe fort.",
          "page_description" => "Page de modification de mot de passe",
          "page_js" => ["modificationPassword.js"],
          "page_title"=> "WebyCloudy | Modification Mot de passe",
          "hero_compact" => true,
          "espace" => "client",
          "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
      }

    public function validation_modificationPassword($ancienPassword,$nouveauPassword,$confirmNouveauPassword){
      if($nouveauPassword !== $confirmNouveauPassword){
        Toolbox::ajouterMessageAlerte('Les 2 nouveaux mots de passe ne correspondent pas', Toolbox::COULEUR_ROUGE);
        Toolbox::redirection('compte/modificationPassword');
      }
      if(strlen($nouveauPassword) < 8){
        Toolbox::ajouterMessageAlerte("Le nouveau mot de passe doit contenir au moins 8 caractères.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection('compte/modificationPassword');
      }
      if(!$this->utilisateurManager->isCombinaisonValide($_SESSION['profil']['login'],$ancienPassword)){
        Toolbox::ajouterMessageAlerte("L'ancien mot de passe est incorrect", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection('compte/modificationPassword');
      }
      $passwordCrypte = password_hash($nouveauPassword,PASSWORD_DEFAULT);
      if($this->utilisateurManager->bdModificationPassword($_SESSION['profil']['login'],$passwordCrypte)){
        Toolbox::ajouterMessageAlerte('Le mot de passe a bien été modifié', Toolbox::COULEUR_VERTE);
        Toolbox::redirection("compte/profil");
      }
      Toolbox::ajouterMessageAlerte("La modification n'a pas été effectuée", Toolbox::COULEUR_ROUGE);
      Toolbox::redirection("compte/modificationPassword");
    }

    //ft qui valide la suppression du compte
    public function validation_suppressionCompte(){
      $login = $_SESSION['profil']['login'];
      //Suppression de l'image et du dossier de l'utilisateur
      $this->dossierSuppressionImageUtilisateur();
      $dossier = "public/Assets/images/profils/".$login;
      if(is_dir($dossier)) @rmdir($dossier);
      //Suppression des projets, documents, demandes et messages du client : un futur compte
      //portant le meme login ne doit rien heriter
      $fichiers = $this->espaceManager->bdSupprimerDonneesUtilisateur($login);
      foreach($fichiers as $fichier){
        $chemin = "storage/documents/".$fichier;
        if(is_file($chemin)) unlink($chemin);
      }

      if($this->utilisateurManager->bdSuppressionCompte($login)){
        unset($_SESSION['profil']);
        session_regenerate_id(true);
        Toolbox::ajouterMessageAlerte('La suppression du compte est effectuée.', Toolbox::COULEUR_VERTE);
        Toolbox::redirection("accueils");
      }
      Toolbox::ajouterMessageAlerte("La suppression du compte n'a pas été effectuée, contactez-nous.", Toolbox::COULEUR_ROUGE);
      Toolbox::redirection("compte/profil");
    }

    /**
    *Ft qui gere l'ajout de la nouvelle image de profil
     * suppression de l'ancienne images
     * ajout de nouvelles images dans le repertoire
     */
    public function validation_modificationImage($file){
      try {
        $repertoire = "public/Assets/images/profils/".$_SESSION['profil']['login']."/";
        //Ajout image dans le repertoire
        $nomImage = Toolbox::ajoutImage($file, $repertoire);
        //Supression de l'ancienne images
        $this->dossierSuppressionImageUtilisateur();
        //Ajout de la nouvelle image dans la bdd
        $nomImageBD = "profils/".$_SESSION['profil']['login']."/".$nomImage;
        if($this->utilisateurManager->bdAjoutImage($_SESSION['profil']['login'],$nomImageBD)){
          Toolbox::ajouterMessageAlerte("La photo de profil a été modifiée", Toolbox::COULEUR_VERTE);
        }else{
          Toolbox::ajouterMessageAlerte("La modification de l'image n'a pas été effectuée", Toolbox::COULEUR_ROUGE);
        }
      } catch (\Exception $e) {
        Toolbox::ajouterMessageAlerte($e->getMessage(), Toolbox::COULEUR_ROUGE);
      }
      Toolbox::redirection("compte/profil");
    }

    //ft private Suppression de l'ancienne image
    private function dossierSuppressionImageUtilisateur(){
      $ancienneImage = $this->utilisateurManager->getImageUtilisateur($_SESSION['profil']['login']);
      if($ancienneImage && $ancienneImage !== "profils/profil.png"){
        $chemin = "public/Assets/images/".$ancienneImage;
        if(is_file($chemin)) unlink($chemin);
      }
    }

    //ft page erreur qui appelle la ft du parent-------
    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }

  }
 ?>
