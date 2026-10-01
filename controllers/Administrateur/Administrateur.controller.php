<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/Administrateur/Administrateur.model.php");

  class AdministrateurController extends MainController{

    private $administrateurManager;

    public function __construct(){
      $this->administrateurManager = new AdministrateurManager();
    }

    private function pageAdmin($view, $h1, $uvp, $titre, $donnees){
      $data_page = array_merge([
        "view" => $view,
        "custom_css" => [],
        "H1" => $h1,
        "uvp"=> $uvp,
        "page_description" => $uvp,
        "page_title"=> "WebyCloudy | ".$titre,
        "hero_compact" => true,
        "template" => "views/common/template.php"
      ], $donnees);
      $this->genererPage($data_page);
    }

    public function gestion_droits(){
      $this->pageAdmin("./views/Administrateur/gestionDroits.view.php", "Gestion des rôles",
        "Attribuez et modifiez les rôles des utilisateurs.", "Gestion des Rôles",
        ["utilisateurs" => $this->administrateurManager->getUtilisateurs()]);
    }

    //un administrateur ne peut modifier que les comptes "utilisateur" et ne peut pas créer de super administrateur
    public function validation_modificationRole($login,$role){
      $roleActuel = $this->administrateurManager->getRoleUtilisateur($login);
      $rolesAutorises = Securite::estSuperAdministrateur() ? Securite::ROLES : ["utilisateur", "administrateur"];

      if($roleActuel === null){
        Toolbox::ajouterMessageAlerte("Utilisateur introuvable.", Toolbox::COULEUR_ROUGE);
      }elseif($login === $_SESSION['profil']['login']){
        Toolbox::ajouterMessageAlerte("Vous ne pouvez pas modifier votre propre rôle.", Toolbox::COULEUR_ROUGE);
      }elseif(!in_array($role, $rolesAutorises, true) || (!Securite::estSuperAdministrateur() && $roleActuel !== "utilisateur")){
        Toolbox::ajouterMessageAlerte("Vous n'avez pas les droits pour effectuer cette modification.", Toolbox::COULEUR_ROUGE);
      }elseif($this->administrateurManager->bdModificationRoleUser($login,$role)){
        Toolbox::ajouterMessageAlerte("Le rôle a bien été modifié !", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Aucune modification de rôle n'a été effectuée !", Toolbox::COULEUR_ORANGE);
      }
      Toolbox::redirection("administration/droits");
    }

    public function gestion_utilisateur(){
      $this->pageAdmin("./views/Administrateur/gestionUtilisateurs.view.php", "Gestion des utilisateurs",
        "Consultez la liste des utilisateurs inscrits.", "Gestion des Utilisateurs",
        ["utilisateurs" => $this->administrateurManager->getUtilisateurs()]);
    }

    public function gestion_commandes(){
      $this->pageAdmin("./views/Administrateur/gestionCommandes.view.php", "Gestion des commandes",
        "Consultez l'historique des commandes.", "Gestion des Commandes",
        ["commandes" => $this->administrateurManager->getCommandes()]);
    }

    public function gestion_produits(){
      $this->pageAdmin("./views/Administrateur/gestionProduits.view.php", "Gestion des produits",
        "Consultez les produits proposés.", "Gestion des Produits",
        ["produits" => $this->administrateurManager->getProduits()]);
    }

    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }

  }
 ?>
