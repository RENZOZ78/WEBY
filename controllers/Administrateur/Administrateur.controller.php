<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/Administrateur/Administrateur.model.php");
  require_once("models/Espace/Espace.model.php");

  class AdministrateurController extends MainController{

    private $administrateurManager;
    private $espaceManager;

    public function __construct(){
      $this->administrateurManager = new AdministrateurManager();
      $this->espaceManager = new EspaceManager();
    }

    private function pageAdmin($view, $h1, $uvp, $titre, $donnees = [], $js = []){
      $data_page = array_merge([
        "view" => $view,
        "custom_css" => [],
        "H1" => $h1,
        "uvp"=> $uvp,
        "page_description" => $uvp,
        "page_title"=> "WebyCloudy | ".$titre,
        "page_js" => $js,
        "hero_compact" => true,
        "espace" => "admin",
        "template" => "views/common/template.php"
      ], $donnees);
      $this->genererPage($data_page);
    }

    /* ---------- Tableau de bord ---------- */

    public function tableau(){
      $this->pageAdmin("./views/Administrateur/tableau.view.php", "Administration", "Vue d'ensemble de l'activité", "Administration", [
        "stats" => $this->espaceManager->getStatistiques(),
        "demandes" => $this->espaceManager->getDernieresDemandes(6),
        "projets" => array_slice($this->espaceManager->getProjets(), 0, 6),
      ]);
    }

    /* ---------- Projets ---------- */

    public function projets(){
      $this->pageAdmin("./views/Administrateur/projets.view.php", "Projets", "Suivi des prestations en cours", "Projets", [
        "projets" => $this->espaceManager->getProjets(),
      ]);
    }

    public function nouveauProjet(){
      $this->pageAdmin("./views/Administrateur/projetForm.view.php", "Nouveau projet", "Créer un projet pour un client", "Nouveau projet", [
        "projet" => null,
        "clients" => $this->espaceManager->getClients(),
        "login_defaut" => isset($_GET['client']) ? htmlspecialchars((string)$_GET['client']) : "",
      ]);
    }

    public function projet($id){
      $projet = $this->espaceManager->getProjet($id);
      if(!$projet) throw new Exception("Ce projet n'existe pas");
      $this->pageAdmin("./views/Administrateur/projetForm.view.php", $projet['titre'], "Client : ".$projet['login'], "Projet", [
        "projet" => $projet,
        "clients" => $this->espaceManager->getClients(),
        "documents" => $this->espaceManager->getDocumentsProjet($projet['id']),
      ]);
    }

    //validation commune a la creation et a la modification
    private function verifierProjet($login, $titre, $type, $etape){
      if($titre === "") return "Le titre du projet est obligatoire.";
      if(!isset(EspaceManager::TYPES[$type])) return "Le type de projet n'existe pas.";
      if(!isset(EspaceManager::ETAPES[(int)$etape])) return "L'étape n'existe pas.";
      if($this->administrateurManager->getRoleUtilisateur($login) === null) return "Le client sélectionné n'existe pas.";
      return null;
    }

    public function validation_nouveauProjet($login, $titre, $type, $etape, $note){
      $erreur = $this->verifierProjet($login, $titre, $type, $etape);
      if($erreur){
        Toolbox::ajouterMessageAlerte($erreur, Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("administration/nouveauProjet");
      }
      $id = $this->espaceManager->bdCreerProjet($login, mb_substr($titre, 0, 150), $type, $etape, $note);
      Toolbox::ajouterMessageAlerte("Le projet a été créé.", Toolbox::COULEUR_VERTE);
      Toolbox::redirection("administration/projet/".$id);
    }

    public function validation_projet($id, $login, $titre, $type, $etape, $note){
      $projet = $this->espaceManager->getProjet($id);
      if(!$projet) throw new Exception("Ce projet n'existe pas");
      $erreur = $this->verifierProjet($projet['login'], $titre, $type, $etape);
      if($erreur){
        Toolbox::ajouterMessageAlerte($erreur, Toolbox::COULEUR_ROUGE);
      }else{
        $this->espaceManager->bdModifierProjet($projet['id'], mb_substr($titre, 0, 150), $type, $etape, $note);
        Toolbox::ajouterMessageAlerte("Le projet a été mis à jour.", Toolbox::COULEUR_VERTE);
      }
      Toolbox::redirection("administration/projet/".$projet['id']);
    }

    public function suppression_projet($id){
      $projet = $this->espaceManager->getProjet($id);
      if(!$projet) throw new Exception("Ce projet n'existe pas");
      foreach($this->espaceManager->getDocumentsProjet($projet['id']) as $document){
        $chemin = "storage/documents/".$document['fichier'];
        if(is_file($chemin)) unlink($chemin);
      }
      $this->espaceManager->bdSupprimerProjet($projet['id']);
      Toolbox::ajouterMessageAlerte("Le projet et ses documents ont été supprimés.", Toolbox::COULEUR_ORANGE);
      Toolbox::redirection("administration/projets");
    }

    /* ---------- Documents ---------- */

    public function validation_document($projetId, $file, $nom, $categorie){
      $projet = $this->espaceManager->getProjet($projetId);
      if(!$projet) throw new Exception("Ce projet n'existe pas");
      try {
        if(!isset(EspaceManager::CATEGORIES_DOCUMENT[$categorie])) $categorie = "autre";
        $fichier = Toolbox::ajoutDocument($file, "storage/documents/");
        $nom = $nom !== "" ? mb_substr($nom, 0, 150) : basename($file['name']);
        $this->espaceManager->bdAjouterDocument($projet['id'], $projet['login'], $nom, $fichier, $categorie, $file['size']);
        Toolbox::ajouterMessageAlerte("Le document a été ajouté, le client peut le télécharger.", Toolbox::COULEUR_VERTE);
      } catch (\Exception $e) {
        Toolbox::ajouterMessageAlerte($e->getMessage(), Toolbox::COULEUR_ROUGE);
      }
      Toolbox::redirection("administration/projet/".$projet['id']);
    }

    public function suppression_document($id){
      $document = $this->espaceManager->getDocument($id);
      if(!$document) throw new Exception("Ce document n'existe pas");
      $chemin = "storage/documents/".$document['fichier'];
      if(is_file($chemin)) unlink($chemin);
      $this->espaceManager->bdSupprimerDocument($document['id']);
      Toolbox::ajouterMessageAlerte("Le document a été supprimé.", Toolbox::COULEUR_ORANGE);
      Toolbox::redirection("administration/projet/".$document['projet_id']);
    }

    public function document($id){
      $document = $this->espaceManager->getDocument($id);
      if(!$document) throw new Exception("Ce document n'existe pas");
      Toolbox::envoyerFichier("storage/documents/".$document['fichier'], $document['nom']);
    }

    /* ---------- Demandes ---------- */

    public function demandes(){
      $statut = isset($_GET['statut']) ? (string)$_GET['statut'] : "";
      $this->pageAdmin("./views/Administrateur/demandes.view.php", "Demandes", "Messages du site et des clients", "Demandes", [
        "demandes" => $this->espaceManager->getDemandes($statut),
        "statut_filtre" => isset(EspaceManager::STATUTS_DEMANDE[$statut]) ? $statut : "",
      ]);
    }

    public function demande($id){
      $demande = $this->espaceManager->getDemande($id);
      if(!$demande) throw new Exception("Cette demande n'existe pas");
      $this->pageAdmin("./views/Administrateur/demande.view.php", $demande['sujet'], "Demande n°".$demande['id']." — ".$demande['nom'], "Demande", [
        "demande" => $demande,
        "messages" => $this->espaceManager->getMessages($demande['id']),
      ]);
    }

    //reponse de l'agence : enregistree dans le fil et envoyee par mail au demandeur
    public function validation_reponse($demandeId, $message){
      $demande = $this->espaceManager->getDemande($demandeId);
      if(!$demande) throw new Exception("Cette demande n'existe pas");
      if($message === ""){
        Toolbox::ajouterMessageAlerte("La réponse est vide.", Toolbox::COULEUR_ROUGE);
      }else{
        $this->espaceManager->bdAjouterMessage($demande['id'], $_SESSION['profil']['login'], 1, $message);
        $lien = $demande['login'] ? "\n\nSuivre votre demande : ".URL."compte/demande/".$demande['id'] : "";
        $envoye = Toolbox::envoyerMail(html_entity_decode($demande['mail']), "Re: ".html_entity_decode($demande['sujet']), "Bonjour ".html_entity_decode($demande['nom']).",\n\n".html_entity_decode($message).$lien."\n\nL'équipe WebyCloudy");
        Toolbox::ajouterMessageAlerte($envoye ? "Réponse enregistrée et envoyée par mail." : "Réponse enregistrée (le mail n'a pas pu partir).", $envoye ? Toolbox::COULEUR_VERTE : Toolbox::COULEUR_ORANGE);
      }
      Toolbox::redirection("administration/demande/".$demande['id']);
    }

    public function validation_statutDemande($demandeId, $statut){
      $demande = $this->espaceManager->getDemande($demandeId);
      if(!$demande) throw new Exception("Cette demande n'existe pas");
      if($this->espaceManager->bdChangerStatutDemande($demande['id'], $statut)){
        Toolbox::ajouterMessageAlerte("Statut mis à jour.", Toolbox::COULEUR_VERTE);
      }
      Toolbox::redirection("administration/demande/".$demande['id']);
    }

    /* ---------- Utilisateurs et droits ---------- */

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
      $this->pageAdmin("./views/Administrateur/gestionUtilisateurs.view.php", "Clients",
        "Les comptes inscrits sur le site.", "Clients",
        ["utilisateurs" => $this->administrateurManager->getUtilisateurs()]);
    }

    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }

  }
 ?>
