<?php
  require_once("./controllers/MainController.controller.php");
  require_once("./models/Supervision/Journal.class.php");
  require_once("models/SuperAdministrateur/SuperAdministrateur.model.php");
  require_once("models/Espace/Espace.model.php");

  class SAdministrateurController extends MainController{

    private $sAdministrateurManager;
    private $espaceManager;

    public function __construct(){
      $this->sAdministrateurManager = new SAdministrateurManager();
      $this->espaceManager = new EspaceManager();
    }

    public function gestion_full_utilisateur(){
      $data_page = [
        "view" => "./views/SuperAdministrateur/gestionFullUtilisateur.view.php",
        "custom_css" => [],
        "H1" => "Administration des utilisateurs",
        "uvp"=> "Modifiez toutes les informations des utilisateurs.",
        "page_description" => "Administration complète des utilisateurs",
        "utilisateurs" => $this->sAdministrateurManager->getUtilisateurs(),
        "page_title"=> "WebyCloudy | Administration Utilisateurs",
        "hero_compact" => true,
        "espace" => "admin",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }

    public function validation_modification_full_utilisateur($login,$mail,$role,$is_valid){
      $is_valid = ($is_valid === "1") ? 1 : 0;
      if(!filter_var(html_entity_decode($mail), FILTER_VALIDATE_EMAIL)){
        Toolbox::ajouterMessageAlerte("L'adresse mail n'est pas valide.", Toolbox::COULEUR_ROUGE);
      }elseif(!Securite::estRoleValide($role)){
        Toolbox::ajouterMessageAlerte("Le rôle demandé n'existe pas.", Toolbox::COULEUR_ROUGE);
      }elseif($login === $_SESSION['profil']['login'] && ($role !== "superAdministrateur" || $is_valid !== 1)){
        Toolbox::ajouterMessageAlerte("Vous ne pouvez pas retirer vos propres droits de super administrateur.", Toolbox::COULEUR_ROUGE);
      }elseif($this->sAdministrateurManager->bdModificationFullUtilisateur($login,$mail,$role,$is_valid)){
        Journal::ajouter("utilisateur_modifie", $login." · rôle ".$role." · ".($is_valid ? "validé" : "non validé"));
        Toolbox::ajouterMessageAlerte("L'utilisateur ".$login." a bien été modifié !", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Aucune modification n'a été effectuée.", Toolbox::COULEUR_ORANGE);
      }
      Toolbox::redirection("administration/gestionFullUtilisateur");
    }

    //suppression d'un compte jamais valide (inscription de robot) et de ce qui y serait rattache
    public function suppression_compte_non_valide($login){
      if($login !== "" && $login !== $_SESSION['profil']['login'] && $this->sAdministrateurManager->bdSuppressionCompteNonValide($login)){
        $fichiers = $this->espaceManager->bdSupprimerDonneesUtilisateur($login);
        foreach($fichiers as $fichier){
          $chemin = "storage/documents/".$fichier;
          if(is_file($chemin)) unlink($chemin);
        }
        Journal::ajouter("compte_supprime", $login." · compte non validé supprimé par le super administrateur");
        Toolbox::ajouterMessageAlerte("Le compte non validé a été supprimé.", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Seul un compte client non validé peut être supprimé ici.", Toolbox::COULEUR_ROUGE);
      }
      Toolbox::redirection("administration/gestionFullUtilisateur");
    }

    //suppression d'une demande (spam, faux contact) et de ses messages ; tracee au journal
    public function suppression_demande($id){
      $demande = $this->espaceManager->getDemande($id);
      if($demande && $this->espaceManager->bdSupprimerDemande($demande['id'])){
        Journal::ajouter("demande_supprimee", "n°".$demande['id']." · ".html_entity_decode($demande['nom'])." · ".html_entity_decode($demande['sujet']));
        Toolbox::ajouterMessageAlerte("La demande n°".$demande['id']." a été supprimée.", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Cette demande n'existe pas ou a déjà été supprimée.", Toolbox::COULEUR_ROUGE);
      }
      Toolbox::redirection("administration/demandes");
    }

    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }

  }
 ?>
