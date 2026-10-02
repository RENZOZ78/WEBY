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
    "db_host" => config_env("DB_HOST", "127.0.0.1"),
    "db_name" => config_env("DB_NAME", "webycloudy"),
    "db_user" => config_env("DB_USER", "root"),
    "db_pass" => config_env("DB_PASS", ""),
    "mail_contact" => config_env("MAIL_CONTACT", "webycloudy@gmail.com"),
    "telephone" => "07 62 63 44 70",
    "horaires" => "Du lundi au vendredi, de 10h à 18h",
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
