<?php
  require_once("./models/MainManager.model.php");

  class UtilisateurManager extends MainManager{

    private function getPasswordUser($login){
      $req = "SELECT password FROM utilisateur where login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->execute();
      $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $resultat ? $resultat['password'] : null;
    }
    //ft qui verifie si la combinaison login pwd est valide en pbdd
    public function isCombinaisonValide($login, $password){
      $passwordBD = $this->getPasswordUser($login);
      if($passwordBD === null) return false;
      return password_verify($password, $passwordBD);
      }

      //ft qui affiche  l'etat d'activation d'un compte en bddd
    public function estCompteActive($login){
      //test return false;
      $req = "SELECT is_valid FROM utilisateur where login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->execute();
      $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $resultat && (int)$resultat['is_valid'] === 1;
    }

    //ft qui recupere toutes les infos de l'utilisateur en bdd
    public function getUserInformation($login){
      //test return false;
      $req = "SELECT * FROM utilisateur where login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->execute();
      $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();
      return $resultat;
    }

    //ft qui verfiie si le login existe deja,  est verifLoginDisponible
    public function verifLoginDisponible($login){
      //au lieu de recup les infos, on va juste l'appeler getUserInformation
      $utilisateur = $this->getUserInformation($login);
      return  empty($utilisateur);
    }

    //ft qui crée le compte en getBdd
    public function bdCreerCompte($login,$passwordCrypte,$mail,$clef,$image,$role){
      $req= "INSERT INTO utilisateur (login, password, mail, is_valid, role, clef, image)
      VALUES (:login, :password, :mail, 0, :role, :clef, :image)";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->bindValue(":password",$passwordCrypte,PDO::PARAM_STR);
      $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
      $stmt->bindValue(":clef",$clef,PDO::PARAM_INT);
      $stmt->bindValue(":image",$image,PDO::PARAM_STR);
      $stmt->bindValue(":role",$role,PDO::PARAM_STR);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

    //ft qui modifie la valeur de la colonne isValid en bdd de 0 a 1, pour activer le compte utilisateur apres clic du lien mail
    public function bdValidationMailCompte($login,$clef){
      $req = "UPDATE utilisateur set is_valid = 1 WHERE login = :login and clef = :clef";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->bindValue(":clef",$clef,PDO::PARAM_INT);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

    // fffft qui valide la modif du mail en bdd
    public function bdValidationModificationMail($login,$mail){
      $req= "UPDATE utilisateur set mail = :mail WHERE login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

    //ft qui valide la modif du pwd en bdd
    public function bdModificationPassword($login,$password){
      $req= "UPDATE utilisateur set password = :password WHERE login = :login";
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":login",$login,PDO::PARAM_STR);
      $stmt->bindValue(":password",$password,PDO::PARAM_STR);
      $stmt->execute();
      $estModifier = ($stmt->rowCount() > 0);
      $stmt->closeCursor();
      return $estModifier;
    }

    //function qui supprime le compte en bdModificationPassword
    public function bdSuppressionCompte($login){
    $req= "DELETE  FROM utilisateur  WHERE login = :login";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":login",$login,PDO::PARAM_STR);
    $stmt->execute();
    $estModifier = ($stmt->rowCount() > 0);
    $stmt->closeCursor();
    return $estModifier;
  }

  //ft qui va modifier l'image existante en bdd
  public function bdAjoutImage($login,$image){
    $req= "UPDATE utilisateur set image = :image WHERE login = :login";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":login",$login,PDO::PARAM_STR);
    $stmt->bindValue(":image",$image,PDO::PARAM_STR);
    $stmt->execute();
    $estModifier = ($stmt->rowCount() > 0);
    $stmt->closeCursor();
    return $estModifier;
  }

  //ft qui va recuperer l'ancienne image en bdd
  public function getImageUtilisateur($login){
    $req = "SELECT image FROM utilisateur where login = :login";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":login",$login,PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $resultat ? $resultat['image'] : null;
  }


  }






?>
