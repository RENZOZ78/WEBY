<?php
  require_once("./controllers/MainController.controller.php");
  require_once("./models/Supervision/Supervision.model.php");
  require_once("./models/Espace/Espace.model.php");

  /**
   * Supervision : espace reserve au super administrateur (supervision/...).
   * Tableau de bord personnalisable, audience, journal d'activite, comptes, etat technique.
   */
  class SupervisionController extends MainController{

    //widgets du tableau de bord : id => [titre, icone, largeur par defaut]
    public const WIDGETS = [
      "chiffres" => ["Chiffres clés", "fa-chart-simple", "pleine"],
      "alertes" => ["Points d'attention", "fa-bell", "demi"],
      "activite" => ["Activité récente", "fa-clock-rotate-left", "demi"],
      "audience" => ["Fréquentation", "fa-chart-column", "pleine"],
      "pages" => ["Pages les plus vues", "fa-file-lines", "demi"],
      "sources" => ["Provenance des visiteurs", "fa-signs-post", "demi"],
      "demandes" => ["Demandes", "fa-inbox", "demi"],
      "projets" => ["Projets", "fa-diagram-project", "demi"],
      "comptes" => ["Comptes", "fa-users", "demi"],
      "systeme" => ["État du site", "fa-server", "demi"],
    ];

    public const PERIODES = [7 => "7 jours", 30 => "30 jours", 90 => "90 jours", 365 => "12 mois"];

    //page ouverte apres la connexion du super administrateur
    public const ACCUEILS = ["supervision" => "Supervision", "administration" => "Administration"];

    private const PREFERENCE = "supervision";

    private $supervisionManager;
    private $espaceManager;

    public function __construct(){
      $this->supervisionManager = new SupervisionManager();
      $this->espaceManager = new EspaceManager();
    }

    private function login(){
      return $_SESSION['profil']['login'];
    }

    //le role est relu en base : un compte retrograde perd l'acces immediatement, meme connecte
    public function verifierAcces(){
      $role = $this->supervisionManager->getRoleUtilisateur($this->login());
      if($role !== "superAdministrateur"){
        if($role === null){
          unset($_SESSION['profil']);
        }else{
          $_SESSION['profil']['role'] = $role;
        }
        Toolbox::ajouterMessageAlerte("La supervision est réservée au super administrateur.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("accueils");
      }
    }

    /* ---------- Preferences du tableau de bord ---------- */

    public static function preferencesParDefaut(){
      $widgets = [];
      foreach(self::WIDGETS as $id => $widget) $widgets[] = ["id" => $id, "largeur" => $widget[2]];
      return ["widgets" => $widgets, "periode" => 30, "accueil" => "supervision"];
    }

    //preferences enregistrees, nettoyees (widgets inconnus retires, valeurs hors liste remplacees)
    public function getPreferences($login = null){
      $defaut = self::preferencesParDefaut();
      $json = $this->supervisionManager->getPreference($login ?? $this->login(), self::PREFERENCE);
      $prefs = $json ? json_decode($json, true) : null;
      if(!is_array($prefs)) return $defaut;
      $widgets = [];
      foreach((array)($prefs['widgets'] ?? []) as $widget){
        $id = $widget['id'] ?? "";
        if(isset(self::WIDGETS[$id]) && !isset($widgets[$id])){
          $widgets[$id] = ["id" => $id, "largeur" => ($widget['largeur'] ?? "") === "pleine" ? "pleine" : "demi"];
        }
      }
      return [
        "widgets" => array_values($widgets),
        "periode" => isset(self::PERIODES[(int)($prefs['periode'] ?? 0)]) ? (int)$prefs['periode'] : $defaut['periode'],
        "accueil" => isset(self::ACCUEILS[$prefs['accueil'] ?? ""]) ? $prefs['accueil'] : $defaut['accueil'],
      ];
    }

    //page ouverte apres connexion (utilise par la connexion)
    public static function pageAccueil($login){
      try {
        $prefs = (new self())->getPreferences($login);
        return $prefs['accueil'] === "administration" ? "administration/tableau" : "supervision/tableau";
      } catch (Throwable $e) {
        return "administration/tableau";
      }
    }

    //periode demandee dans l'adresse (?periode=), sinon celle des preferences
    private function periode($defaut){
      $periode = (int)($_GET['periode'] ?? 0);
      return isset(self::PERIODES[$periode]) ? $periode : $defaut;
    }

    private function pageSupervision($view, $h1, $uvp, $titre, $donnees = []){
      $this->genererPage(array_merge([
        "view" => $view,
        "custom_css" => ["supervision.css"],
        "H1" => $h1,
        "uvp" => $uvp,
        "page_description" => $uvp,
        "page_title" => "WebyCloudy | ".$titre,
        "hero_compact" => true,
        "espace" => "admin",
        "template" => "views/common/template.php"
      ], $donnees));
    }

    /* ---------- Tableau de bord ---------- */

    public function tableau(){
      $prefs = $this->getPreferences();
      $periode = $this->periode($prefs['periode']);
      $affiches = array_column($prefs['widgets'], "id");
      $m = $this->supervisionManager;
      //seules les donnees des widgets affiches sont calculees
      $donnees = ["prefs" => $prefs, "periode" => $periode];
      $besoin = function($ids) use ($affiches){ return (bool)array_intersect((array)$ids, $affiches); };
      if($besoin(["chiffres", "audience"])) $donnees['audience'] = $m->getAudienceComparee($periode);
      if($besoin("audience")) $donnees['serie'] = $m->getVisitesSerie($periode);
      if($besoin(["chiffres", "comptes"])) $donnees['comptes'] = $m->getStatsComptes($periode);
      if($besoin(["chiffres", "demandes", "alertes"])) $donnees['demandes'] = $m->getStatsDemandes($periode);
      if($besoin(["chiffres", "projets", "alertes"])) $donnees['projets'] = $m->getStatsProjets();
      if($besoin(["chiffres", "systeme"])) $donnees['documents'] = $m->getStatsDocuments($periode);
      if($besoin("chiffres")) $donnees['conversion'] = $m->getConversion($periode);
      if($besoin("alertes")){
        $donnees['echecs'] = $m->getEchecsConnexion(24);
        $donnees['attente'] = $m->getDemandesEnAttente(4);
        $donnees['comptes_attente'] = $m->getStatsComptes($periode)['non_valides'];
      }
      if($besoin("activite")) $donnees['evenements'] = $m->getDernierEvenements(8);
      if($besoin("pages")) $donnees['pages'] = $m->getRepartitionVisites("page", $periode, 7);
      if($besoin("sources")) $donnees['sources'] = $m->getRepartitionVisites("source", $periode, 7);
      if($besoin("systeme")) $donnees['systeme'] = $this->etatSysteme(false);

      $this->pageSupervision("./views/SuperAdministrateur/supervision/tableau.view.php", "Supervision",
        "Bonjour ".$this->login()." : tout ce qui se passe sur le site, d'un coup d'œil.", "Supervision", $donnees);
    }

    /* ---------- Audience ---------- */

    public function audience(){
      $periode = $this->periode($this->getPreferences()['periode']);
      $m = $this->supervisionManager;
      $this->pageSupervision("./views/SuperAdministrateur/supervision/audience.view.php", "Audience",
        "Fréquentation des pages publiques du site, sans cookie ni outil externe.", "Audience", [
        "periode" => $periode,
        "audience" => $m->getAudienceComparee($periode),
        "serie" => $m->getVisitesSerie($periode),
        "heures" => $m->getVisitesParHeure($periode),
        "pages" => $m->getRepartitionVisites("page", $periode, 15),
        "sources" => $m->getRepartitionVisites("source", $periode, 15),
        "appareils" => $m->getRepartitionVisites("appareil", $periode, 3),
        "conversion" => $m->getConversion($periode),
      ]);
    }

    /* ---------- Journal d'activite ---------- */

    public function activite(){
      $periode = $this->periode(30);
      $categorie = isset(Journal::CATEGORIES[$_GET['categorie'] ?? ""]) ? $_GET['categorie'] : "";
      $login = mb_substr(trim((string)($_GET['login'] ?? "")), 0, 50);
      $page = max(1, (int)($_GET['p'] ?? 1));
      [$evenements, $total] = $this->supervisionManager->getJournal($categorie, Securite::secureHTML($login), $periode, $page, 50);
      $this->pageSupervision("./views/SuperAdministrateur/supervision/activite.view.php", "Journal d'activité",
        "Connexions, comptes, demandes, projets, documents et droits : qui a fait quoi, et quand.", "Journal d'activité", [
        "periode" => $periode,
        "categorie" => $categorie,
        "login_filtre" => $login,
        "evenements" => $evenements,
        "total" => $total,
        "page" => $page,
        "pages_total" => max(1, (int)ceil($total / 50)),
        "echecs" => $this->supervisionManager->getEchecsConnexion(24 * 7),
      ]);
    }

    /* ---------- Comptes ---------- */

    public function comptes(){
      $periode = $this->periode($this->getPreferences()['periode']);
      $this->pageSupervision("./views/SuperAdministrateur/supervision/comptes.view.php", "Comptes",
        "Tous les comptes du site, leur rôle et leur activité.", "Comptes", [
        "periode" => $periode,
        "stats" => $this->supervisionManager->getStatsComptes($periode),
        "comptes" => $this->supervisionManager->getComptes($periode),
      ]);
    }

    /* ---------- Etat technique ---------- */

    //etat du serveur ; $complet ajoute le detail des tables (page Systeme)
    private function etatSysteme($complet = true){
      $systeme = $complet ? $this->supervisionManager->getSysteme() : ["php" => PHP_VERSION];
      //derniere mise a jour des fichiers du site (date du dernier deploiement)
      $derniere = 0;
      foreach(["index.php", "controllers", "models", "views", "inc", "public/CSS", "public/Javascript"] as $chemin){
        if(is_file($chemin)){ $derniere = max($derniere, filemtime($chemin)); continue; }
        if(!is_dir($chemin)) continue;
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($chemin, FilesystemIterator::SKIP_DOTS)) as $fichier){
          $derniere = max($derniere, $fichier->getMTime());
        }
      }
      $stockage = 0;
      if(is_dir("storage/documents")){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator("storage/documents", FilesystemIterator::SKIP_DOTS)) as $fichier){
          $stockage += $fichier->getSize();
        }
      }
      $libre = @disk_free_space(".");
      $config = require("config/config.php");
      return array_merge($systeme, [
        "deploiement" => $derniere ? date("Y-m-d H:i:s", $derniere) : null,
        "stockage" => $stockage,
        "disque_libre" => $libre === false ? null : (int)$libre,
        "https" => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off",
        "mail" => function_exists("mail"),
        "mail_contact" => $config['mail_contact'],
        "erreurs_affichees" => in_array(strtolower((string)ini_get("display_errors")), ["1", "on", "stdout"], true),
        "stockage_ecriture" => is_writable("storage/documents"),
        "schema" => (int)@file_get_contents("storage/.schema"),
      ]);
    }

    public function systeme(){
      $this->pageSupervision("./views/SuperAdministrateur/supervision/systeme.view.php", "État du site",
        "Serveur, base de données, stockage et réglages de sécurité.", "État du site", [
        "systeme" => $this->etatSysteme(true),
        "documents" => $this->supervisionManager->getStatsDocuments(30),
      ]);
    }

    /* ---------- Personnalisation ---------- */

    public function personnaliser(){
      $this->pageSupervision("./views/SuperAdministrateur/supervision/personnaliser.view.php", "Personnaliser",
        "Choisissez ce que vous voyez, dans quel ordre, et où vous arrivez après la connexion.", "Personnaliser la supervision", [
        "prefs" => $this->getPreferences(),
      ]);
    }

    public function validation_personnaliser(){
      if(post("reinitialiser") === "1"){
        $this->supervisionManager->supprimerPreference($this->login(), self::PREFERENCE);
        Toolbox::ajouterMessageAlerte("Le tableau de bord a retrouvé sa présentation d'origine.", Toolbox::COULEUR_VERTE);
        Toolbox::redirection("supervision/tableau");
      }
      $afficher = (array)($_POST['afficher'] ?? []);
      $positions = (array)($_POST['position'] ?? []);
      $largeurs = (array)($_POST['largeur'] ?? []);
      $widgets = [];
      $rang = 0;
      foreach(array_keys(self::WIDGETS) as $id){
        $rang++;
        if(empty($afficher[$id])) continue;
        $widgets[] = [
          "id" => $id,
          "largeur" => ($largeurs[$id] ?? "") === "pleine" ? "pleine" : "demi",
          "ordre" => (int)($positions[$id] ?? $rang) * 100 + $rang,
        ];
      }
      usort($widgets, function($a, $b){ return $a['ordre'] <=> $b['ordre']; });
      $prefs = [
        "widgets" => array_map(function($w){ return ["id" => $w['id'], "largeur" => $w['largeur']]; }, $widgets),
        "periode" => isset(self::PERIODES[(int)post("periode")]) ? (int)post("periode") : 30,
        "accueil" => isset(self::ACCUEILS[post("accueil")]) ? post("accueil") : "supervision",
      ];
      $this->supervisionManager->setPreference($this->login(), self::PREFERENCE, json_encode($prefs));
      Toolbox::ajouterMessageAlerte("Votre tableau de bord est enregistré.", Toolbox::COULEUR_VERTE);
      Toolbox::redirection("supervision/tableau");
    }

    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }
  }
