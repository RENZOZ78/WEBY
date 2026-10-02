<?php

  abstract class Model{
    private static $pdo;

    //ft qui parametre la connection a la bdd (identifiants dans config/config.php)
    private static function setBdd(){
      $config = require(__DIR__."/../config/config.php");
      $dsn = "mysql:host=".$config['db_host'].";dbname=".$config['db_name'].";charset=utf8mb4";
      self::$pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //ft qui recupere la connexion a la bdd
    protected function getBdd(){
      if(self::$pdo === null){
        self::setBdd();
      }
      return self::$pdo;
    }
  }

 ?>
