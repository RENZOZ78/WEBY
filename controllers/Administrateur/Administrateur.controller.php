<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/MainManager.model.php");
  require_once("models/Administrateur/Administrateur.model.php");

  class AdministrateurController extends MainController{

    private $administrateurManager;

    //constructeur pour creer une instance de MainManager
    public function __construct(){
      $this->administrateurManager = new AdministrateurManager();
    }

    public function gestion_droits(){
    $utilisateurs = $this->administrateurManager->getUtilisateurs();
      $data_page = [
        "view" => "./views/Administrateur/gestionDroits.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gérer les droits utilisateurs",
        "uvp"=> "Ici vous pouvez gérer les droits utilisateurs",
        "utilisateurs" => $utilisateurs,
        "page_title"=> "WebyCloudy | Gestion droits",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function validation_modificationRole($login,$role){
      if($this->administrateurManager->bdModificationRoleUser($login,$role)){
        Toolbox::ajouterMessageAlerte("Le role est bien modifié !", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Aucune modification de rôle n'a été effectuée !", Toolbox::COULEUR_ROUGE);
      }
        header ("Location: ".URL."administration/droits");
    }

    public function gestion_utilisateur(){
    $utilisateurs = $this->administrateurManager->getUtilisateurs();
      $data_page = [
        "view" => "./views/Administrateur/gestionUtilisateurs.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gérer les droits utilisateurs",
        "uvp"=> "Ici vous pouvez gérer les droits utilisateurs",
        "utilisateurs" => $utilisateurs,
        "page_title"=> "WebyCloudy | Gestion droits ",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function gestion_commandes(){
    // $utilisateurs = $this->administrateurManager->getUtilisateurs();
    $commandes = $this->administrateurManager->getCommandes();
      $data_page = [
        "view" => "./views/Administrateur/gestionCommandes.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gérer les droits utilisateurs",
        "uvp"=> "Ici vous pouvez gérer les droits utilisateurs",
        "commandes" => $commandes,
        "page_title"=> "WebyCloudy | Gestion droits ",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function gestion_produits(){
    $produits = $this->administrateurManager->getProduits();
      $data_page = [
        "view" => "./views/Administrateur/gestionProduits.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gestion des produits",
        "uvp"=> "Ici vous pouvez gérer les produits",
        "produits" => $produits,
        "page_title"=> "WebyCloudy | Gestion produits ",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    //ft page erreur qui appelle la ft du parent-------
    public function pageErreur($msg){
      parent::pageErreur($msg);
    }

  }
 ?>
