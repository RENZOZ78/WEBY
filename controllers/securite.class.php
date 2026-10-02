<?php

  class Securite{
    public const ROLES = ["utilisateur", "administrateur", "superAdministrateur"];

    public static function secureHTML($chaine){
      return htmlentities((string)$chaine);
    }

    public static function estConnecte(){
      return (!empty($_SESSION['profil']));
    }

    private static function role(){
      return $_SESSION['profil']['role'] ?? null;
    }

    public static function estUtilisateur(){
      return self::role() === "utilisateur";
    }

    public static function estAdministrateur(){
      return self::role() === "administrateur";
    }

    public static function estSuperAdministrateur(){
      return self::role() === "superAdministrateur";
    }

    public static function estRoleValide($role){
      return in_array($role, self::ROLES, true);
    }

    //jeton anti-CSRF stocké en session, à inclure dans chaque formulaire POST
    public static function csrfToken(){
      if(empty($_SESSION['csrf'])){
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
      }
      return $_SESSION['csrf'];
    }

    public static function csrfField(){
      return '<input type="hidden" name="csrf" value="'.self::csrfToken().'">';
    }

    public static function verifierCsrf(){
      return !empty($_POST['csrf']) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
    }
  }

 ?>
