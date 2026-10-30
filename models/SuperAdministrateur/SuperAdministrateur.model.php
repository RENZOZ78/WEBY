<?php
  require_once("./models/Administrateur/Administrateur.model.php");

  class SAdministrateurManager extends AdministrateurManager{

    //modification complete d'un utilisateur (mail, role, validation du compte)
    public function bdModificationFullUtilisateur($login,$mail,$role,$is_valid){
      $req= "UPDATE utilisateur set mail = :mail, role = :role, is_valid = :is_valid WHERE login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
      $stmt->bindValue(":role",$role,PDO::PARAM_STR);
      $stmt->bindValue(":is_valid",$is_valid,PDO::PARAM_INT);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

    //suppression d'un compte client jamais valide par mail (inscriptions de robots) ;
    //un compte valide, administrateur ou super administrateur n'est jamais supprime ici
    public function bdSuppressionCompteNonValide($login){
      $req= "DELETE FROM utilisateur WHERE login = :login AND is_valid = 0 AND role = 'utilisateur'";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

  }

?>
