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
      //echo password_hash("test", PASSWORD_DEFAULT);
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/accueil.view.php",
        "custom_css" => ["style.css", "accueil.css"], // Garder les CSS spécifiques
        "H1" => "Accueil",
        "page_js" => ["accueil.js"],
        "page_title"=> "WebyCloudy | Accueil "
      ]);
    }

    //ft page entreprise-----------------
    public function entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Créer votre société",
        "uvp"=> "Vos projets sont nos inspirations",
        "page_title"=> "WebyCloudy | Société "
      ]);
    }

    //ft page creation entreprise-----------
    public function creation_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creation_entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Créer votre société",
        "uvp"=> "Il est temps de passer à l'action",
        "page_title"=> "WebyCloudy | création société "
      ]);
    }

    //ft page gestion entreprise-----------
    public function gestion_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/gestion_entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Gérer votre société",
        "uvp"=> "Gérer votre société pour donner la bonne direction",
        "page_title"=> "WebyCloudy | gestion société "
      ]);
    }

      //ft page modification entreprise-----------
      public function modification_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/suppression_entreprise.view.php",
        "custom_css" => ["style.css", "accueil.css"],
        "H1" => "Modification votre société",
        "uvp"=> "Effectuer toutes les modifications",
        "page_title"=> "WebyCloudy | Suppression société "
      ]);
    }

      //ft page site-----------------------
      public function site(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/site.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Créer votre site internet",
        "uvp"=> "Profitez de la puissance de votre site web",
        "page_title"=> "WebyCloudy | Site "
      ]);
    }

    //ft page reseau sociaux--------------
    public function reseaux(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/reseau.view.php",
        "custom_css" => ["style.css"],
        "H1" => "Les réseaux sociaux",
        "uvp"=> "Profitez de votre audience sur les réseaux sociaux",
        "page_title"=> "WebyCloudy | Reseaux sociaux "
      ]);
    }

    //ft page marketing--------------------
  public function marketing(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/marketing.view.php",
        "custom_css" => ["projets.css", "marketing.css"],
        "H1" => "Publicité",
        "uvp"=> "Il est temps de faire passer votre activité au niveau supérieur",
        "page_title"=> "WebyCloudy | Publicité "
      ]);
  }

  //ft page contact----------------
  public function contact(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/contact.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Contact",
        "uvp"=> "Restons en contact",
        "page_title"=> "WebyCloudy | Contact "
      ]);
  }

  //ft page login----------------
  public function login(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/login.view.php",
        "custom_css" => ["projets.css"],
        "H1" => "Creation de compte",
        "uvp"=> "Veuillez entrer vos logins et mot de passe",
        "page_title"=> "WebyCloudy | Login "
      ]);
  }

    //ft qui genere les infos a la vue creerCompte.view
    public function creerCompte(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creerCompte.view.php",
        "custom_css" => ["creerCompte.css"],
        "H1" => "Créer votre compte",
        "uvp"=> "Afin d'avoir accès à outes les infos, veuillez créer votre compte",
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
