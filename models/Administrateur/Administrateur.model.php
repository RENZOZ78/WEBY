<?php
  require_once("./models/MainManager.model.php");

  class AdministrateurManager extends MainManager{

    //recuperation de data des utilisateurs
    public function getUtilisateurs(){
        $req = $this->getBdd()->prepare("SELECT * FROM utilisateur ORDER BY login");
        $req->execute();
        $utilisateur = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $utilisateur;
    }



    //recuperation du role actuel d'un utilisateur
    public function getRoleUtilisateur($login){
      $stmt = $this->getBdd()->prepare("SELECT role FROM utilisateur WHERE login = :login");
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->execute();
      $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $resultat ? $resultat['role'] : null;
    }

    public function bdModificationRoleUser($login,$role){
      $req= "UPDATE utilisateur set role = :role WHERE login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->bindValue(":role",$role,PDO::PARAM_STR);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

  }



?>
