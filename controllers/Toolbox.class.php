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

    //ft qui affiche une date MySQL en francais (ex : 3 oct. 2026 à 14h05)
    public static function dateFr($dateSql, $heure = true){
      if(!$dateSql) return "";
      $ts = strtotime($dateSql);
      $mois = ["janv.", "févr.", "mars", "avr.", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."];
      $texte = (int)date("j", $ts)." ".$mois[(int)date("n", $ts) - 1]." ".date("Y", $ts);
      return $heure ? $texte." à ".date("H\\hi", $ts) : $texte;
    }

    //ft qui affiche une taille de fichier lisible
    public static function tailleFichier($octets){
      if($octets >= 1048576) return round($octets / 1048576, 1)." Mo";
      if($octets >= 1024) return round($octets / 1024)." Ko";
      return $octets." o";
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

    //ft qui envoie un fichier au navigateur en telechargement puis arrete le script
    public static function envoyerFichier($chemin, $nomAffiche){
      if(!is_file($chemin)) throw new Exception("Le fichier est introuvable sur le serveur");
      //le nom affiche garde l'extension reelle du fichier
      $extension = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));
      if($extension !== "" && strtolower(pathinfo($nomAffiche, PATHINFO_EXTENSION)) !== $extension) $nomAffiche .= ".".$extension;
      $nomAffiche = preg_replace('/[^A-Za-z0-9._ -]/', '_', $nomAffiche);
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"".$nomAffiche."\"");
      header("Content-Length: ".filesize($chemin));
      header("X-Content-Type-Options: nosniff");
      readfile($chemin);
      exit();
    }

    //ft qui enregistre un document client (PDF, image, Office, zip) et renvoie son nom sur le disque
    public static function ajoutDocument($file, $dir){
      if(!isset($file['name']) || $file['name'] === "" || !is_uploaded_file($file['tmp_name']))
        throw new Exception("Vous devez sélectionner un fichier");
      if($file['size'] > 10 * 1024 * 1024)
        throw new Exception("Le fichier est trop gros (10 Mo maximum)");
      $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      $autorisees = ["pdf", "jpg", "jpeg", "png", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "odt", "ods", "zip", "txt"];
      if(!in_array($extension, $autorisees, true))
        throw new Exception("Type de fichier non autorisé (PDF, images, Office, zip)");
      $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
      if(in_array($mime, ["application/x-httpd-php", "text/x-php", "application/x-sh", "text/html"], true))
        throw new Exception("Type de fichier non autorisé");
      if(!is_dir($dir)) mkdir($dir, 0755, true);
      $nomDisque = bin2hex(random_bytes(12)).".".$extension;
      if(!move_uploaded_file($file['tmp_name'], $dir.$nomDisque))
        throw new Exception("L'enregistrement du fichier a échoué");
      return $nomDisque;
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
