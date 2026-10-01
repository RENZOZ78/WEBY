<?php
  class Toolbox {
    public const COULEUR_ORANGE = "alert-warning";
    public const COULEUR_ROUGE = "alert-danger";
    public const COULEUR_VERTE = "alert-success";

    //fonciton qui envoie des alertes
    public static function ajouterMessageAlerte($message,$type){
      $_SESSION['alert'][]=[
        "message" => $message,
        "type" => $type
      ];
      return $_SESSION;
    }

    //ft qui redirige vers une page du site et arrete le script
    public static function redirection($chemin){
      header("Location: ".URL.$chemin);
      exit();
    }

    //ft qui envoie des mails aux utilisateurs
    public static function envoyerMail($destinataire,$sujet,$message,$repondreA = null){
      $headers = [
        "From" => "WebyCloudy <webycloudy@gmail.com>",
        "Content-Type" => "text/plain; charset=UTF-8",
      ];
      if($repondreA) $headers["Reply-To"] = $repondreA;
      $sujet = "=?UTF-8?B?".base64_encode($sujet)."?=";
      return @mail($destinataire,$sujet,$message,$headers);
    }

    //ft qui envoie le mail de validation et affiche le resultat
    public static function sendMail($destinataire,$sujet,$message){
      if(self::envoyerMail($destinataire,$sujet,$message)){
        self::ajouterMessageAlerte("Mail de validation a été envoyé", self::COULEUR_VERTE);
      }else{
        self::ajouterMessageAlerte("Le mail n'a pas pu être envoyé. Contactez-nous si le problème persiste.", self::COULEUR_ROUGE);
      }
    }

    //ft qui permet de rajouter une images
    public static function ajoutImage($file, $dir){
      if(!isset($file['name']) || empty($file['name']))
        throw new Exception("Vous devez indiquer une image");
      if(!is_uploaded_file($file['tmp_name']))
        throw new Exception("Le fichier n'a pas été envoyé correctement");

      if(!file_exists($dir)) mkdir($dir,0755,true);

      $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
      $random = random_int(0,99999);
      $nomFichier = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($file['name']));
      $target_file = $dir.$random."_".$nomFichier;

      if(!getimagesize($file["tmp_name"]))
        throw new Exception("Le ficher n'est pas une image");
      if(!in_array($extension, ["jpg","jpeg","png","gif","webp"], true))
        throw new Exception("L'extension du fichier n'est pas reconnue");
      if(file_exists($target_file))
        throw new Exception("Le fichier existe déja");
      if($file['size'] > 500000)
        throw new Exception("Le fichier est trop gros (500 Ko maximum)");
      if(!move_uploaded_file($file['tmp_name'], $target_file))
          throw new Exception("l'ajout de l'image n'a pas fonctionné");
      return ($random."_".$nomFichier);
    }
  }
