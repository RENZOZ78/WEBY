<?php
  require_once("./controllers/MainController.controller.php");
  require_once("models/Espace/Espace.model.php");

  class VisiteurController extends MainController{

    private $espaceManager;

    public function __construct(){
      $this->espaceManager = new EspaceManager();
    }

    // Méthode privée pour générer les pages et éviter la répétition
    private function generatePageWithOptions($options){
        $default_options = [
            "view" => "",
            "custom_css" => [],
            "H1" => "",
            "page_js" => [],
            "uvp"=> "Vos idées sont nos inspirations",
            "page_description" => "WebyCloudy : business plan, création de société, site internet, gestion administrative et stratégie marketing pour les entrepreneurs.",
            "page_title"=> "WebyCloudy",
            "template" => "views/common/template.php"
        ];
        $this->genererPage(array_merge($default_options, $options));
    }

    //ft qui gere les infos de la page d'accueils--------
    public  function accueil(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/accueil.view.php",
        "H1" => "Lancez et développez votre entreprise",
        "uvp"=> "Business plan · Création de société · Site internet · Marketing",
        "hero_texte" => "De l'idée au chiffre d'affaires : nous créons votre société, votre site internet et votre stratégie de croissance. Vous vous concentrez sur votre métier.",
        "hero_accueil" => true,
        "page_title"=> "WebyCloudy | Création d'entreprise, site internet & croissance"
      ]);
    }

    //ft page lancement : business plan + creation de societe-----------------
    public function lancement(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/lancement.view.php",
        "H1" => "Business plan & création de société",
        "uvp"=> "Pack Lancement & Financement",
        "hero_texte" => "Vous lancez votre projet ? Mettez toutes les chances de votre côté pour convaincre votre banquier et l'administration. 95 % de nos clients ont validé leur dossier.",
        "hero_image" => "public/Assets/images/entreprise/BP.png",
        "hero_badges" => ["fa-file-invoice|Business plan dès 299 €", "fa-stamp|Création dès 200 € + frais", "fa-bolt|Livraison 48h à 7 jours"],
        "page_description" => "Business plan professionnel, prévisionnel financier, création de société (SASU, SARL, EURL, micro-entreprise) et aide au prêt bancaire.",
        "page_title"=> "WebyCloudy | Business plan & création de société"
      ]);
    }

    //ft page gestion & administratif-----------------
    public function gestion(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/gestion.view.php",
        "H1" => "Gestion & administratif à la carte",
        "uvp"=> "Pack Croissance",
        "hero_texte" => "Libérez-vous du temps pour votre métier : contrats, fiches de paie, entrées et sorties de salariés, devis et factures. Nous gérons la paperasse.",
        "hero_image" => "public/Assets/images/entreprise/brainstorming.png",
        "hero_badges" => ["fa-users|RH dès 30 €", "fa-file-invoice-dollar|Devis & factures pros", "fa-clock|Réponse sous 48h"],
        "page_description" => "Gestion RH (contrats, fiches de paie, DPAE, DSN) et facturation pour les petites entreprises.",
        "page_title"=> "WebyCloudy | Gestion & administratif"
      ]);
    }

    //ft page site-----------------------
    public function site(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/site.view.php",
        "H1" => "Votre site internet professionnel",
        "uvp"=> "Pack Croissance",
        "hero_texte" => "Site vitrine ou e-commerce moderne et responsive, référencé sur Google, maintenu et fluide. Votre activité visible 24h/24.",
        "hero_image" => "public/Assets/images/site%20internet/si3.png",
        "hero_badges" => ["fa-laptop-code|Dès 300 €", "fa-magnifying-glass|Référencement SEO inclus", "fa-mobile-screen|PC, tablette & mobile"],
        "page_description" => "Création de site vitrine ou e-commerce, responsive et optimisé SEO, avec maintenance.",
        "page_title"=> "WebyCloudy | Site internet professionnel"
      ]);
    }

    //ft page marketing & croissance--------------------
    public function marketing(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/marketing.view.php",
        "H1" => "Stratégie marketing & croissance",
        "uvp"=> "Pack Croissance",
        "hero_texte" => "Votre société manque de visibilité ? Vous n'obtenez pas autant de clients que vous le souhaitez ? Audit, acquisition clients et image de marque : nous avons la solution.",
        "hero_image" => "public/Assets/images/strategie_marketing/st3.png",
        "hero_badges" => ["fa-bullhorn|Dès 500 €", "fa-chart-line|Vendre plus et plus cher", "fa-star|95 % de clients satisfaits"],
        "page_description" => "Audit d'activité, acquisition de clients, réseaux sociaux, publicité et image de marque.",
        "page_title"=> "WebyCloudy | Stratégie marketing & croissance"
      ]);
    }

    //ft page contact----------------
    public function contact(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/contact.view.php",
        "H1" => "Parlons de votre projet",
        "uvp"=> "Devis gratuit · Réponse sous 48h · France entière",
        "page_description" => "Contactez l'agence WebyCloudy pour un devis gratuit.",
        "page_title"=> "WebyCloudy | Contact ",
        "hero_compact" => true
      ]);
    }

    //ft qui traite le formulaire de contact : enregistre la demande puis previent l'agence par mail
    public function validation_contact($nom, $mail, $message, $sujet){
      $config = require("config/config.php");
      if($nom === "" || $message === "" || !filter_var($mail, FILTER_VALIDATE_EMAIL)){
        Toolbox::ajouterMessageAlerte("Merci de renseigner votre nom, un email valide et votre message.", Toolbox::COULEUR_ROUGE);
        Toolbox::redirection("contact");
      }
      $sujet = $sujet !== "" ? mb_substr($sujet, 0, 150) : "Demande de contact";
      $login = Securite::estConnecte() ? $_SESSION['profil']['login'] : null;
      $id = $this->espaceManager->bdCreerDemande($login, Securite::secureHTML(mb_substr($nom, 0, 100)), Securite::secureHTML($mail), Securite::secureHTML($sujet), Securite::secureHTML($message));

      $corps = "Nouveau message depuis le site WebyCloudy (demande n°".$id.")\n\n"
        ."Nom : ".$nom."\nEmail : ".$mail."\nSujet : ".$sujet."\n\n".$message
        ."\n\nRépondre depuis l'administration : ".URL."administration/demande/".$id;
      Toolbox::envoyerMail($config['mail_contact'], "Contact site : ".$sujet, $corps, $mail);

      Toolbox::ajouterMessageAlerte("Merci ".htmlspecialchars($nom)." ! Votre message a bien été reçu, nous vous répondons sous 48h.", Toolbox::COULEUR_VERTE);
      Toolbox::redirection($login ? "compte/demande/".$id : "contact");
    }

    //ft page login----------------
    public function login(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/login.view.php",
        "H1" => "Connexion",
        "uvp"=> "Espace client",
        "page_title"=> "WebyCloudy | Connexion ",
        "hero_compact" => true
      ]);
    }

    //ft qui genere les infos a la vue creerCompte.view
    public function creerCompte(){
      $this->generatePageWithOptions([
        "view" => "./views/Visiteur/creerCompte.view.php",
        "H1" => "Créer mon espace client",
        "uvp"=> "Suivez vos projets, vos documents et vos demandes",
        "page_title"=> "WebyCloudy | Créer un compte ",
        "hero_compact" => true
      ]);
    }

    public function pageErreur($msg, $code = 404){
      parent::pageErreur($msg, $code);
    }

  }
 ?>
