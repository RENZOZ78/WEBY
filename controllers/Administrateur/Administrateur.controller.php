<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/MainManager.model.php");
  require_once("models/Administrateur/Administrateur.model.php");

  class AdministrateurController extends MainController{

    private $administrateurManager;

    public function __construct(){
      $this->administrateurManager = new AdministrateurManager();
    }

    public function gestion_droits(){
    $utilisateurs = $this->administrateurManager->getUtilisateurs();
      $data_page = [
        "view" => "./views/Administrateur/gestionDroits.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gestion des Rôles",
        "uvp"=> "Attribuez et modifiez les rôles des utilisateurs.",
        "utilisateurs" => $utilisateurs,
        "page_title"=> "WebyCloudy | Gestion des Rôles",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function validation_modificationRole($login,$role){
      if($this->administrateurManager->bdModificationRoleUser($login,$role)){
        Toolbox::ajouterMessageAlerte("Le rôle a bien été modifié !", Toolbox::COULEUR_VERTE);
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
        "H1" => "Gestion des Utilisateurs",
        "uvp"=> "Consultez la liste des utilisateurs inscrits.",
        "utilisateurs" => $utilisateurs,
        "page_title"=> "WebyCloudy | Gestion des Utilisateurs",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function gestion_commandes(){
    $commandes = $this->administrateurManager->getCommandes();
      $data_page = [
        "view" => "./views/Administrateur/gestionCommandes.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gestion des Commandes",
        "uvp"=> "Consultez l'historique des commandes.",
        "commandes" => $commandes,
        "page_title"=> "WebyCloudy | Gestion des Commandes",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function gestion_produits(){
    $produits = $this->administrateurManager->getProduits();
      $data_page = [
        "view" => "./views/Administrateur/gestionProduits.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Gestion des Produits",
        "uvp"=> "Ajoutez, modifiez ou supprimez des produits.",
        "produits" => $produits,
        "page_title"=> "WebyCloudy | Gestion des Produits",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function pageErreur($msg){
      parent::pageErreur($msg);
    }

  }
 ?>
