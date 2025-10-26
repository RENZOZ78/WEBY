<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/MainManager.model.php");
  require_once("models/SuperAdministrateur/SuperAdministrateur.model.php");

  class SAdministrateurController extends MainController{

    private $sAdministrateurManager;

    public function __construct(){
      $this->sAdministrateurManager = new SAdministrateurManager();
    }

    public function gestion_full_utilisateur(){
    $utilisateurs = $this->sAdministrateurManager->getUtilisateurs();
      $data_page = [
        "view" => "./views/SuperAdministrateur/gestionFullUtilisateur.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Administration Complète des Utilisateurs",
        "uvp"=> "Modifiez toutes les informations des utilisateurs.",
        "utilisateurs" => $utilisateurs,
        "page_title"=> "WebyCloudy | Administration Utilisateurs",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function validation_modification_full_utilisateur($login,$role,$mail,$is_valid){
      if($this->sAdministrateurManager->bdModificationRoleUser($login,$role,$mail,$is_valid)){
        Toolbox::ajouterMessageAlerte("Le rôle a bien été modifié !", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Aucune modification de rôle n'a été effectuée !", Toolbox::COULEUR_ROUGE);
      }
        header ("Location: ".URL."administration/droits");
    }

    public function gestion_commandes(){
    $commandes = $this->sAdministrateurManager->getCommandes();
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
    $produits = $this->sAdministrateurManager->getProduits();
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
