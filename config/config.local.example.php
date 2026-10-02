<?php
  /**
   * Exemple de configuration locale : copier ce fichier en config/config.local.php
   * et renseigner les identifiants. config.local.php n'est jamais versionne.
   */
  return [
    "db_host" => "127.0.0.1",
    "db_name" => "u000000000_webycloudy",
    "db_user" => "u000000000_weby",
    "db_pass" => "mot-de-passe-de-la-base",
    "mail_contact" => "webycloudy@gmail.com",
    //compte super administrateur cree au premier lancement si la table est vide de super admin
    "admin_login" => "admin",
    "admin_mail" => "webycloudy@gmail.com",
    "admin_password" => "a-changer-des-la-premiere-connexion",
  ];
