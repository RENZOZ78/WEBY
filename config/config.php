<?php
  /**
   * Configuration de l'application.
   * Les valeurs peuvent être surchargées par des variables d'environnement
   * (recommandé en production) : DB_HOST, DB_NAME, DB_USER, DB_PASS, MAIL_CONTACT.
   * Le téléphone et les horaires affichés sur le site se modifient ici.
   * Les valeurs par défaut correspondent à une installation XAMPP locale.
   * En production, créer config/config.local.php (voir config.local.example.php) : il surcharge ces valeurs.
   */
  if (!function_exists('config_env')) {
    function config_env($cle, $defaut){
      $valeur = getenv($cle);
      return ($valeur === false) ? $defaut : $valeur;
    }
  }

  $config = [
    //adresse officielle du site : URL canoniques et plan du site (sitemap.xml) donnés à Google
    "site_url" => config_env("SITE_URL", "https://webycloudy.com/"),
    "db_host" => config_env("DB_HOST", "127.0.0.1"),
    "db_name" => config_env("DB_NAME", "webycloudy"),
    "db_user" => config_env("DB_USER", "root"),
    "db_pass" => config_env("DB_PASS", ""),
    "mail_contact" => config_env("MAIL_CONTACT", "info@webycloudy.com"),
    "telephone" => "06 52 47 37 99",
    "horaires" => "Du lundi au vendredi, de 10h à 18h",

    //--- Identité légale de l'éditeur (pages mentions-legales et confidentialite, pied de page) ---
    //A REMPLIR PAR LE PROPRIETAIRE. Tant qu'une valeur obligatoire est vide, les pages légales affichent
    //« à compléter » en évidence, ne sont pas proposées à Google et ne figurent pas dans le plan du site.
    "legal_nom" => "",          //obligatoire : raison sociale, ou nom et prénom pour une entreprise individuelle
    "legal_forme" => "",        //obligatoire : forme juridique (ex. « SASU », « Entrepreneur individuel (micro-entreprise) »)
    "legal_siret" => "",        //obligatoire : numéro SIRET (14 chiffres)
    "legal_adresse" => "",      //obligatoire : adresse du siège ou de l'établissement
    "legal_responsable" => "",  //obligatoire : nom et prénom du responsable (directeur) de la publication
    "legal_capital" => "",      //facultatif : capital social (sociétés uniquement, ex. « 1 000 € »)
    "legal_rcs" => "",          //facultatif : immatriculation (ex. « RCS Versailles 123 456 789 » ou répertoire des métiers)
    "legal_tva" => "",          //facultatif : numéro de TVA intracommunautaire, ou « TVA non applicable, art. 293 B du CGI »

    //--- Hébergeur du site (mentions légales) ---
    //Source : conditions générales de Hostinger (entité contractante pour l'Union européenne), relevées le 2026-11-21 :
    //https://www.hostinger.com/legal/universal-terms-of-service-agreement
    "hebergeur_nom" => "Hostinger International Limited",
    "hebergeur_adresse" => "61 Lordou Vironos Street, 6023 Larnaca, Chypre",
    "hebergeur_telephone" => "", //Hostinger ne publie pas de numéro de téléphone : laissé vide (non affiché)
    "hebergeur_contact" => "https://www.hostinger.com/contacts",

    //--- Bloc « Qui suis-je » (inc/partials/qui_suis_je.php : page contact et accueil) ---
    //Le bloc ne s'affiche que lorsque le prénom, le texte ET la photo sont renseignés (et que la photo existe).
    "qui_prenom" => "",         //prénom affiché
    "qui_role" => "",           //facultatif : fonction (ex. « Fondateur de WebyCloudy »)
    "qui_texte" => "",          //présentation et parcours ; une ligne vide sépare deux paragraphes
    "qui_photo" => "",          //chemin de la photo dans le dépôt (ex. « public/Assets/images/accueil/portrait.jpg »)
    //compte super administrateur cree automatiquement a la premiere installation (laisser vide pour ne rien creer)
    "admin_login" => "",
    "admin_mail" => "",
    "admin_password" => "",
  ];

  //surcharge locale (identifiants de production) : config/config.local.php, jamais versionne
  $local = __DIR__."/config.local.php";
  if(is_file($local)){
    $config = array_merge($config, (array)require($local));
  }
  return $config;
