<?php

  abstract class Model{
    private static $pdo;

    //ft qui parametre la connection a la bdd
    private static function setBdd(){
      self::$pdo = new PDO("mysql:host=127.0.0.1;dbname=webycloudy;charset=utf8", "root", "");

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
