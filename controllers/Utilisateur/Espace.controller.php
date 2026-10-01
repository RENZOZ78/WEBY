<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/Espace/Espace.model.php");
  require_once("models/Utilisateur/Utilisateur.model.php");

  /**
   * Espace client : tableau de bord, suivi des projets, documents et demandes.
   * Toutes les methodes supposent un utilisateur connecte (verifie par le routeur).
   */
  class EspaceController extends MainController{

    private $espaceManager;
    private $utilisateurManager;

    public function __construct(){
      $this->espaceManager = new EspaceManager();
      $this->utilisateurManager = new UtilisateurManager();
    }

    private function login(){
      return $_SESSION['profil']['login'];
    }

    private function pageEspace($view, $h1, $uvp, $titre, $donnees = [], $js = []){
      $data_page = array_merge([
        "view" => $view,
        "custom_css" => [],
        "H1" => $h1,
        "uvp"=> $uvp,
        "page_description" => "Espace client WebyCloudy",
        "page_title"=> "WebyCloudy | ".$titre,
        "page_js" => $js,
        "hero_compact" => true,
        "espace" => "client",
        "template" => "views/common/template.php"
      ], $donnees);
      $this->genererPage($data_page);
    }

    //tableau de bord : projets en cours, derniers documents, demandes ouvertes
    public function tableau(){
      $login = $this->login();
      $projets = $this->espaceManager->getProjetsUtilisateur($login);
      $documents = array_slice($this->espaceManager->getDocumentsUtilisateur($login), 0, 5);
      $demandes = $this->espaceManager->getDemandesUtilisateur($login);
      $this->pageEspace("./views/Utilisateur/tableau.view.php", "Bonjour ".$login, "Votre espace client", "Mon espace", [
        "projets" => $projets,
        "documents" => $documents,
        "demandes" => array_slice($demandes, 0, 5),
        "utilisateur" => $this->utilisateurManager->getUserInformation($login),
      ]);
    }

    public function projets(){
      $this->pageEspace("./views/Utilisateur/projets.view.php", "Mes projets", "Suivez l'avancement de vos prestations", "Mes projets", [
        "projets" => $this->espaceManager->getProjetsUtilisateur($this->login()),
      ]);
    }

    public function projet($id){
      $projet = $this->espaceManager->getProjet($id, $this->login());
      if(!$projet) throw new Exception("Ce projet n'existe pas");
      $this->pageEspace("./views/Utilisateur/projet.view.php", $projet['titre'], EspaceManager::TYPES[$projet['type']] ?? "Projet", "Projet", [
        "projet" => $projet,
        "documents" => $this->espaceManager->getDocumentsProjet($projet['id']),
      ]);
    }

    public function documents(){
      $this->pageEspace("./views/Utilisateur/documents.view.php", "Mes documents", "Devis, factures, contrats et rapports", "Mes documents", [
        "documents" => $this->espaceManager->getDocumentsUtilisateur($this->login()),
      ]);
    }

    //telechargement d'un document appartenant a l'utilisateur
    public function document($id){
      $document = $this->espaceManager->getDocument($id, $this->login());
      if(!$document) throw new Exception("Ce document n'existe pas");
      Toolbox::envoyerFichier("storage/documents/".$document['fichier'], $document['nom']);
    }

    public function demandes(){
      $this->pageEspace("./views/Utilisateur/demandes.view.php", "Mes demandes", "Posez vos questions, nous vous répondons sous 48h", "Mes demandes", [
        "demandes" => $this->espaceManager->getDemandesUtilisateur($this->login()),
      ]);
    }

    public function demande($id){
      $demande = $this->espaceManager->getDemande($id, $this->login());
      if(!$demande) throw new Exception("Cette demande n'existe pas");
      $this->pageEspace("./views/Utilisateur/demande.view.php", $demande['sujet'], "Demande n°".$demande['id'], "Demande", [
        "demande" => $demande,
        "messages" => $this->espaceManager->getMessages($demande['id']),
      ]);
    }

    public function nouvelleDemande(){
      $this->pageEspace("./views/Utilisateur/nouvelleDemande.view.php", "Nouvelle demande", "Une question, une modification, un nouveau projet ?", "Nouvelle demande", [
        "sujet_defaut" => isset($_GET['sujet']) ? htmlspecialchars(substr((string)$_GET['sujet'], 0, 120)) : "",
      ]);
    }

    public function validation_nouvelleDemande($sujet, $message){
      if($sujet === "" || $message === ""){
        Toolbox::ajouterMessageAlerte("Merci d'indiquer un sujet et un message.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("compte/nouvelleDemande");
      }
      $utilisateur = $this->utilisateurManager->getUserInformation($this->login());
      $id = $this->espaceManager->bdCreerDemande($this->login(), $this->login(), $utilisateur['mail'], mb_substr($sujet, 0, 150), $message);
      $this->notifierAgence("Nouvelle demande client : ".$sujet, "Le client ".$this->login()." a envoyé une demande :\n\n".html_entity_decode($message)."\n\nRépondre : ".URL."administration/demande/".$id);
      Toolbox::ajouterMessageAlerte("Votre demande a bien été envoyée, nous vous répondons sous 48h.", Toolbox::COULEUR_VERTE);
      Toolbox::redirection("compte/demande/".$id);
    }

    public function validation_message($demandeId, $message){
      $demande = $this->espaceManager->getDemande($demandeId, $this->login());
      if(!$demande) throw new Exception("Cette demande n'existe pas");
      if($message === ""){
        Toolbox::ajouterMessageAlerte("Le message est vide.", Toolbox::COULEUR_ROUGE);
      }else{
        $this->espaceManager->bdAjouterMessage($demande['id'], $this->login(), 0, $message);
        $this->notifierAgence("Réponse client sur la demande n°".$demande['id'], $this->login()." a répondu :\n\n".html_entity_decode($message)."\n\nVoir : ".URL."administration/demande/".$demande['id']);
        Toolbox::ajouterMessageAlerte("Votre message a été envoyé.", Toolbox::COULEUR_VERTE);
      }
      Toolbox::redirection("compte/demande/".$demande['id']);
    }

    //previent l'agence par mail (silencieux si le mail n'est pas configure)
    private function notifierAgence($sujet, $corps){
      $config = require("config/config.php");
      Toolbox::envoyerMail($config['mail_contact'], $sujet, $corps);
    }

    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }
  }
