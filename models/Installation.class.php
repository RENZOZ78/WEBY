<?php
  require_once("models/Model.class.php");

  /**
   * Installation automatique : au premier lancement, cree les tables (database.sql)
   * et le compte super administrateur defini dans la configuration.
   * Le fichier storage/.installed marque une installation terminee.
   */
  class Installation extends Model{

    private const MARQUEUR = "storage/.installed";

    //n'interrompt jamais le site : tant que la base n'est pas configuree, seules les pages
    //qui en ont besoin echouent (les pages publiques restent accessibles)
    public static function verifier(){
      if(is_file(self::MARQUEUR)) return;
      try {
        (new self())->installer();
      } catch (PDOException $e) {
        error_log("Installation en attente de la base de données : ".$e->getMessage());
      }
    }

    private function installer(){
      $bdd = $this->getBdd();
      //creation des tables (on ignore les instructions de creation/selection de base)
      $sql = file_get_contents("database.sql");
      $sql = preg_replace('/^\s*--.*$/m', '', $sql);
      foreach(array_filter(array_map('trim', explode(";", $sql))) as $instruction){
        if(preg_match('/^(CREATE DATABASE|USE)\b/i', $instruction)) continue;
        $bdd->exec($instruction);
      }
      //compte super administrateur initial
      $config = require("config/config.php");
      if($config['admin_login'] !== "" && $config['admin_password'] !== ""){
        $existe = (int)$bdd->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'superAdministrateur'")->fetchColumn();
        if($existe === 0){
          $stmt = $bdd->prepare("INSERT INTO utilisateur (login, password, mail, is_valid, role, clef, image) VALUES (?, ?, ?, 1, 'superAdministrateur', 0, 'profils/profil.png')");
          $stmt->execute([htmlentities($config['admin_login']), password_hash($config['admin_password'], PASSWORD_DEFAULT), htmlentities($config['admin_mail']) ]);
        }
      }
      if(!is_dir("storage/documents")) mkdir("storage/documents", 0755, true);
      file_put_contents(self::MARQUEUR, date("c"));
    }
  }
