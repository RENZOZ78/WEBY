<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/MainManager.model.php");
  require_once("models/Visiteur/Visiteur.model.php");

  class VisiteurController extends MainController{

    private $visiteurManager;

    //constructeur pour creer une instance de MainManager
    public function __construct(){
      $this->visiteurManager = new VisiteurManager();
    }

    // Méthode privée pour générer les pages et éviter la répétition
    private function generatePageWithOptions($options){
        // Valeurs par défaut
        $default_options = [
            "view" => "",
            "custom_css" => ["style.css"],
            "produits" => $this->visiteurManager->getProduits(),
            "H1" => "",
            "page_js" => [],
            "uvp"=> "Vos idées sont nos inspirations",
            "page_title"=> "WebyCloudy",
            "template" => "views/common/template.php"
        ];

        // Fusionner les options par défaut avec celles fournies
        $data_page = array_merge($default_options, $options);

        $this->genererPage($data_page);
    }

    //ft qui gere les infos de la page d'accueils--------
    public  function accueil(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/accueil.view.php",
        "custom_css" => ["style.css", "accueil.css"], // Garder les CSS spécifiques
        "H1" => "Bienvenue",
        "uvp"=> "Vos idées sont nos inspirations",
        "page_js" => ["accueil.js"],
        "page_title"=> "WebyCloudy | Accueil "
      ]);
    }

    //ft page entreprise-----------------
    public function entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Création de Société",
        "uvp"=> "Lancez votre activité sur des bases solides",
        "page_title"=> "WebyCloudy | Société "
      ]);
    }

    //ft page creation entreprise-----------
    public function creation_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creation_entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Création de Société",
        "uvp"=> "Il est temps de passer à l'action",
        "page_title"=> "WebyCloudy | Création société "
      ]);
    }

    //ft page gestion entreprise-----------
    public function gestion_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/gestion_entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Gestion de Société",
        "uvp"=> "Pilotez votre activité vers le succès",
        "page_title"=> "WebyCloudy | Gestion société "
      ]);
    }

      //ft page modification entreprise-----------
      public function modification_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/suppression_entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Modification de Société",
        "uvp"=> "Mettez à jour les informations de votre entreprise",
        "page_title"=> "WebyCloudy | Modification société "
      ]);
    }

      //ft page site-----------------------
      public function site(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/site.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Création de Site Web",
        "uvp"=> "Votre vitrine numérique, puissante et moderne",
        "page_title"=> "WebyCloudy | Site Web "
      ]);
    }

    //ft page reseau sociaux--------------
    public function reseaux(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/reseau.view.php",
        "custom_css" => ["style.css"],
        "H1" => "Gestion des Réseaux Sociaux",
        "uvp"=> "Engagez et développez votre communauté",
        "page_title"=> "WebyCloudy | Réseaux sociaux "
      ]);
    }

    //ft page marketing--------------------
  public function marketing(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/marketing.view.php",
        "custom_css" => ["projets.css", "marketing.css"],
        "H1" => "Stratégie Marketing & Publicité",
        "uvp"=> "Passez au niveau supérieur et touchez votre cible",
        "page_title"=> "WebyCloudy | Publicité "
      ]);
  }

  //ft page contact----------------
  public function contact(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/contact.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Nous Contacter",
        "uvp"=> "Une question ? Un projet ? Parlons-en.",
        "page_title"=> "WebyCloudy | Contact "
      ]);
  }

  //ft page login----------------
  public function login(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/login.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Connexion",
        "uvp"=> "Heureux de vous revoir !",
        "page_title"=> "WebyCloudy | Login "
      ]);
  }

    //ft qui genere les infos a la vue creerCompte.view
    public function creerCompte(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creerCompte.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Création de Compte",
        "uvp"=> "Rejoignez notre plateforme en quelques clics",
        "page_title"=> "WebyCloudy | Créer compte "
      ]);
    }

    //ft page erreur qui appelle la ft du parent-------
    //on ne veut pas de page erreur specifique aux visiteur => on laisse la ft principale dans le controlller
    public function pageErreur($msg){
      parent::pageErreur($msg);
    }

  }
 ?>
