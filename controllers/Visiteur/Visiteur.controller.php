<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/Visiteur/Visiteur.model.php");

  class VisiteurController extends MainController{

    private $visiteurManager;

    //constructeur pour creer une instance de VisiteurManager
    public function __construct(){
      $this->visiteurManager = new VisiteurManager();
    }

    // Méthode privée pour générer les pages et éviter la répétition
    private function generatePageWithOptions($options){
        // Valeurs par défaut
        $default_options = [
            "view" => "",
            "custom_css" => [],
            "H1" => "",
            "page_js" => [],
            "uvp"=> "Vos idées sont nos inspirations",
            "page_description" => "WebyCloudy, agence web : création de société, sites internet, réseaux sociaux et marketing digital.",
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
        "H1" => "Faites décoller votre activité",
        "uvp"=> "Vos idées sont nos inspirations",
        "hero_texte" => "Création de société, site internet, réseaux sociaux et publicité : une seule agence pour lancer et faire grandir votre entreprise.",
        "hero_accueil" => true,
        "page_title"=> "WebyCloudy | Agence web & création d'entreprise"
      ]);
    }

    //ft page entreprise-----------------
    public function entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/entreprise.view.php",
        "H1" => "Création de société",
        "uvp"=> "Lancez votre activité sur des bases solides",
        "page_description" => "Création, gestion, modification et fermeture de société avec WebyCloudy.",
        "hero_texte" => "Statuts, Journal officiel, K-bis, paie : nous gérons les démarches pour que vous puissiez vous concentrer sur votre métier.",
        "hero_image" => "public/Assets/images/accueil/entreprise%20rc.png",
        "page_title"=> "WebyCloudy | Société "
      ]);
    }

    //ft page creation entreprise-----------
    public function creation_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creation_entreprise.view.php",
        "H1" => "Création de société",
        "uvp"=> "Il est temps de passer à l'action",
        "hero_image" => "public/Assets/images/accueil/entreprise%20rc.png",
        "page_title"=> "WebyCloudy | Création société "
      ]);
    }

    //ft page gestion entreprise-----------
    public function gestion_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/gestion_entreprise.view.php",
        "H1" => "Gestion de société",
        "uvp"=> "Pilotez votre activité vers le succès",
        "hero_image" => "public/Assets/images/entreprise/BP2.png",
        "page_title"=> "WebyCloudy | Gestion société "
      ]);
    }

      //ft page modification entreprise-----------
      public function modification_entreprise(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/suppression_entreprise.view.php",
        "H1" => "Modification de société",
        "uvp"=> "Mettez à jour les informations de votre entreprise",
        "hero_image" => "public/Assets/images/entreprise/BP3.png",
        "page_title"=> "WebyCloudy | Modification société "
      ]);
    }

      //ft page site-----------------------
      public function site(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/site.view.php",
        "H1" => "Création de site web",
        "uvp"=> "Votre vitrine numérique, puissante et moderne",
        "page_description" => "Sites vitrines, blogs et e-commerce responsives et optimisés SEO.",
        "hero_texte" => "Site vitrine, blog ou boutique en ligne : un site rapide, responsive et optimisé pour Google.",
        "hero_image" => "public/Assets/images/site%20internet/si3.png",
        "page_title"=> "WebyCloudy | Site Web "
      ]);
    }

    //ft page reseau sociaux--------------
    public function reseaux(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/reseau.view.php",
        "H1" => "Gestion des réseaux sociaux",
        "uvp"=> "Engagez et développez votre communauté",
        "page_description" => "Animation de communauté, publicité et e-réputation sur les réseaux sociaux.",
        "hero_texte" => "Facebook, Instagram, Snapchat, Google : nous animons votre communauté et soignons votre e-réputation.",
        "hero_image" => "public/Assets/images/reseaux%20sociaux/rx4.png",
        "page_title"=> "WebyCloudy | Réseaux sociaux "
      ]);
    }

    //ft page marketing--------------------
  public function marketing(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/marketing.view.php",
        "H1" => "Stratégie marketing & publicité",
        "uvp"=> "Passez au niveau supérieur et touchez votre cible",
        "page_description" => "Campagnes Google Ads, Facebook, Instagram et TikTok Ads.",
        "hero_texte" => "Google Ads, Facebook, Instagram et TikTok Ads : des campagnes ciblées pour obtenir des clients plus rapidement.",
        "page_title"=> "WebyCloudy | Publicité "
      ]);
  }

  //ft page contact----------------
  public function contact(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/contact.view.php",
        "H1" => "Nous contacter",
        "uvp"=> "Une question ? Un projet ? Parlons-en.",
        "page_description" => "Contactez l'agence WebyCloudy.",
        "page_title"=> "WebyCloudy | Contact ",
        "hero_compact" => true
      ]);
  }

  //ft qui traite le formulaire de contact-----------
  public function validation_contact($nom, $mail, $message, $sujet){
      $config = require("config/config.php");
      if($nom === "" || $message === "" || !filter_var($mail, FILTER_VALIDATE_EMAIL)){
        Toolbox::ajouterMessageAlerte("Merci de renseigner votre nom, un email valide et votre message.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("contact");
      }
      $corps = "Nouveau message depuis le site WebyCloudy\n\n"
        ."Nom : ".$nom."\nEmail : ".$mail."\nSujet : ".($sujet !== "" ? $sujet : "-")."\n\n".$message;
      if(Toolbox::envoyerMail($config['mail_contact'], "Contact site : ".($sujet !== "" ? $sujet : $nom), $corps, $mail)){
        Toolbox::ajouterMessageAlerte("Merci ".htmlspecialchars($nom)." ! Votre message a bien été envoyé, nous vous répondons sous 48h.", Toolbox::COULEUR_VERTE);
      }else{
        Toolbox::ajouterMessageAlerte("Votre message n'a pas pu être envoyé. Appelez-nous ou écrivez-nous directement à ".$config['mail_contact'].".", Toolbox::COULEUR_ROUGE);
      }
      Toolbox::redirection("contact");
  }

  //ft page login----------------
  public function login(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/login.view.php",
        "H1" => "Connexion",
        "uvp"=> "Heureux de vous revoir !",
        "page_title"=> "WebyCloudy | Login ",
        "hero_compact" => true
      ]);
  }

    //ft qui genere les infos a la vue creerCompte.view
    public function creerCompte(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creerCompte.view.php",
        "H1" => "Création de compte",
        "uvp"=> "Rejoignez notre plateforme en quelques clics",
        "page_title"=> "WebyCloudy | Créer compte ",
        "hero_compact" => true
      ]);
    }

    //ft page erreur qui appelle la ft du parent-------
    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }

  }
 ?>
