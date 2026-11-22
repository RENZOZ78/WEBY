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
    //Avec smtp_pass renseigné (config/config.local.php), le mail part par le serveur SMTP authentifié de la boîte
    //(smtp.hostinger.com) : il est alors signé DKIM et reconnu par le SPF du domaine, donc il n'arrive plus en
    //courrier indésirable. Sans mot de passe SMTP, repli sur mail() de PHP (comportement d'avant).
    public static function envoyerMail($destinataire,$sujet,$message,$repondreA = null){
      $config = require(__DIR__."/../config/config.php");
      $expediteur = $config['mail_contact'];
      if(trim((string)($config['smtp_pass'] ?? "")) !== ""){
        $envoye = self::envoyerMailSmtp($config, $expediteur, $destinataire, $sujet, $message, $repondreA);
        if($envoye) return true;
        //echec SMTP : on tente quand meme mail() pour ne rien perdre, et on le note dans le journal
      }
      $headers = [
        "From" => "WebyCloudy <".$expediteur.">",
        "Content-Type" => "text/plain; charset=UTF-8",
      ];
      if($repondreA) $headers["Reply-To"] = $repondreA;
      $sujetCode = "=?UTF-8?B?".base64_encode($sujet)."?=";
      return @mail($destinataire,$sujetCode,$message,$headers,"-f".$expediteur);
    }

    //envoi par SMTP authentifie (SSL implicite sur 465, ou STARTTLS sur 587) ; renvoie true si le serveur a accepte le mail
    private static function envoyerMailSmtp($config, $expediteur, $destinataire, $sujet, $message, $repondreA){
      $hote = $config['smtp_host'] ?? "smtp.hostinger.com";
      $port = (int)($config['smtp_port'] ?? 465);
      $securite = $config['smtp_secure'] ?? ($port === 465 ? "ssl" : "tls");
      $utilisateur = $config['smtp_user'] ?? $expediteur;
      $nettoyer = function($v){ return str_replace(["\r", "\n"], "", (string)$v); };
      $destinataire = $nettoyer($destinataire);
      $repondreA = $repondreA ? $nettoyer($repondreA) : null;
      $etape = "connexion";
      try {
        $contexte = stream_context_create(["ssl" => ["verify_peer" => true, "verify_peer_name" => true, "peer_name" => $hote]]);
        $cible = ($securite === "ssl" ? "ssl://" : "tcp://").$hote.":".$port;
        $flux = @stream_socket_client($cible, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $contexte);
        if(!$flux) throw new RuntimeException($errstr ?: "connexion impossible");
        stream_set_timeout($flux, 15);
        $lire = function() use ($flux){
          $reponse = "";
          while(($ligne = fgets($flux, 1024)) !== false){
            $reponse .= $ligne;
            if(strlen($ligne) < 4 || $ligne[3] === " ") break;
          }
          return $reponse;
        };
        $commande = function($texte, $attendu) use ($flux, $lire, &$etape){
          if($texte !== null) fwrite($flux, $texte."\r\n");
          $reponse = $lire();
          if((int)substr($reponse, 0, 3) !== $attendu) throw new RuntimeException($etape." : ".trim(substr($reponse, 0, 120)));
          return $reponse;
        };
        $nomLocal = parse_url($config['site_url'] ?? "", PHP_URL_HOST) ?: "webycloudy.com";
        $commande(null, 220);
        $etape = "EHLO"; $commande("EHLO ".$nomLocal, 250);
        if($securite === "tls"){
          $etape = "STARTTLS"; $commande("STARTTLS", 220);
          if(!stream_socket_enable_crypto($flux, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) throw new RuntimeException("STARTTLS refusé");
          $etape = "EHLO"; $commande("EHLO ".$nomLocal, 250);
        }
        if($securite !== "none"){
          $etape = "authentification";
          $commande("AUTH LOGIN", 334);
          $commande(base64_encode($utilisateur), 334);
          $commande(base64_encode($config['smtp_pass']), 235);
        }
        $etape = "expéditeur"; $commande("MAIL FROM:<".$expediteur.">", 250);
        $etape = "destinataire"; $commande("RCPT TO:<".$destinataire.">", 250);
        $etape = "DATA"; $commande("DATA", 354);
        $domaine = substr(strrchr($expediteur, "@"), 1) ?: $nomLocal;
        $entetes = [
          "Date: ".date("r"),
          "From: WebyCloudy <".$expediteur.">",
          "To: <".$destinataire.">",
          "Subject: =?UTF-8?B?".base64_encode($sujet)."?=",
          "Message-ID: <".bin2hex(random_bytes(12))."@".$domaine.">",
          "MIME-Version: 1.0",
          "Content-Type: text/plain; charset=UTF-8",
          "Content-Transfer-Encoding: base64",
        ];
        if($repondreA) $entetes[] = "Reply-To: ".$repondreA;
        $corps = rtrim(chunk_split(base64_encode($message), 76, "\r\n"));
        $etape = "envoi"; $commande(implode("\r\n", $entetes)."\r\n\r\n".$corps."\r\n.", 250);
        fwrite($flux, "QUIT\r\n");
        fclose($flux);
        return true;
      } catch (Throwable $e) {
        if(isset($flux) && is_resource($flux)) fclose($flux);
        $detail = "SMTP ".$hote." · ".$e->getMessage();
        error_log("Mail : ".$detail);
        if(class_exists("Journal")) Journal::ajouter("mail_echec", mb_substr($detail, 0, 200));
        return false;
      }
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
