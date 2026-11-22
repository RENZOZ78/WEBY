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
    //envoi des mails par le serveur SMTP de la boîte (sinon : mail() de PHP, classé en indésirable par Hostinger).
    //Le mot de passe se met UNIQUEMENT dans config/config.local.php sur le serveur ("smtp_pass" => "…").
    "smtp_host" => config_env("SMTP_HOST", "smtp.hostinger.com"),
    "smtp_port" => (int)config_env("SMTP_PORT", "465"),
    "smtp_secure" => config_env("SMTP_SECURE", "ssl"), //ssl (port 465), tls (587, STARTTLS), none (tests locaux)
    "smtp_user" => config_env("SMTP_USER", "info@webycloudy.com"),
    "smtp_pass" => config_env("SMTP_PASS", ""),
    "telephone" => "06 52 47 37 99",
    "horaires" => "Du lundi au vendredi, de 10h à 18h",

    //--- Identité légale de l'éditeur (pages mentions-legales et confidentialite, pied de page) ---
    //Valeurs reprises le 2026-11-22, à la demande du propriétaire, des mentions légales de son autre site
    //sportmaniax.com (même entreprise). Société : Weby Weba Solutions ; nom commercial : WebyCloudy (précisé par le
    //propriétaire). Son nom n'apparaît que comme responsable de la publication. La TVA reste à confirmer.
    // Tant qu'une valeur obligatoire est vide, les pages légales affichent
    //« à compléter » en évidence, ne sont pas proposées à Google et ne figurent pas dans le plan du site.
    "legal_nom" => "Weby Weba Solutions",          //obligatoire : raison sociale, ou nom et prénom pour une entreprise individuelle
    "legal_nom_commercial" => "WebyCloudy", //facultatif : nom commercial, affiché sur sa propre ligne (sans le nom du dirigeant)
    "legal_forme" => "Entrepreneur individuel (micro-entrepreneur)",        //obligatoire : forme juridique (ex. « SASU », « Entrepreneur individuel (micro-entreprise) »)
    "legal_siret" => "503 389 983 00035",        //obligatoire : numéro SIRET (14 chiffres)
    "legal_adresse" => "14 square Albert Camus, 92390 Villeneuve-la-Garenne, France",      //obligatoire : adresse du siège ou de l'établissement
    "legal_responsable" => "Didier Baptistin",  //obligatoire : nom et prénom du responsable (directeur) de la publication
    "legal_capital" => "",      //facultatif : capital social (sociétés uniquement, ex. « 1 000 € »)
    "legal_rcs" => "RCS Nanterre 503 389 983",          //facultatif : immatriculation (ex. « RCS Versailles 123 456 789 » ou répertoire des métiers)
    "legal_tva" => "",          //facultatif : numéro de TVA intracommunautaire, ou « TVA non applicable, art. 293 B du CGI »

    //--- Hébergeur du site (mentions légales) ---
    //Source : conditions générales de Hostinger (entité contractante pour l'Union européenne), relevées le 2026-11-21 :
    //https://www.hostinger.com/legal/universal-terms-of-service-agreement
    "hebergeur_nom" => "Hostinger International Limited",
    "hebergeur_adresse" => "61 Lordou Vironos Street, 6023 Larnaca, Chypre",
    "hebergeur_telephone" => "", //Hostinger ne publie pas de numéro de téléphone : laissé vide (non affiché)
    "hebergeur_contact" => "https://www.hostinger.com/contacts",

    //--- Bloc de présentation « Qui sommes-nous ? » (inc/partials/qui_suis_je.php : page contact et accueil) ---
    //Le bloc ne s'affiche que lorsque le texte ET la photo sont renseignés (et que le fichier de la photo existe).
    "qui_titre" => "Qui sommes-nous ?", //titre du bloc
    "qui_prenom" => "",         //facultatif : nom affiché sous le titre (prénom, ou nom de l'équipe)
    "qui_role" => "",           //facultatif : fonction ou précision affichée après le nom
    //texte fourni par le propriétaire le 2026-11-22 ; une ligne vide sépare deux paragraphes
    "qui_texte" => "Nous sommes un groupe de professionnels animés par une même passion : faire évoluer les projets jusqu'au succès.\n\nDepuis plusieurs années, nous accompagnons des activités de tous les domaines et de toutes les tailles.",
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
