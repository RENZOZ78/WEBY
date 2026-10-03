<?php
  require_once(__DIR__."/../Model.class.php");

  /**
   * Journal d'activite du site (supervision du super administrateur) :
   * connexions, comptes, demandes, projets, documents, droits.
   * L'ecriture ne bloque jamais le site : en cas d'erreur, l'evenement est simplement perdu.
   */
  class Journal extends Model{

    //categories affichees dans les filtres de la supervision
    public const CATEGORIES = [
      "securite" => "Sécurité",
      "comptes" => "Comptes",
      "demandes" => "Demandes",
      "projets" => "Projets",
      "documents" => "Documents",
      "droits" => "Droits",
    ];

    //type => [libelle, icone Font Awesome, categorie]
    public const TYPES = [
      "connexion" => ["Connexion", "fa-right-to-bracket", "securite"],
      "connexion_echec" => ["Échec de connexion", "fa-triangle-exclamation", "securite"],
      "connexion_non_validee" => ["Connexion d'un compte non validé", "fa-user-clock", "securite"],
      "deconnexion" => ["Déconnexion", "fa-right-from-bracket", "securite"],
      "mot_de_passe" => ["Mot de passe changé", "fa-key", "securite"],
      "inscription" => ["Création de compte", "fa-user-plus", "comptes"],
      "compte_valide" => ["Compte validé par mail", "fa-user-check", "comptes"],
      "profil" => ["Profil modifié", "fa-user-pen", "comptes"],
      "compte_supprime" => ["Compte supprimé", "fa-user-xmark", "comptes"],
      "demande_contact" => ["Message du formulaire de contact", "fa-envelope", "demandes"],
      "demande_client" => ["Nouvelle demande d'un client", "fa-inbox", "demandes"],
      "message_client" => ["Réponse d'un client", "fa-comment", "demandes"],
      "reponse_agence" => ["Réponse de l'agence", "fa-reply", "demandes"],
      "statut_demande" => ["Statut de demande changé", "fa-flag", "demandes"],
      "projet_cree" => ["Projet créé", "fa-diagram-project", "projets"],
      "projet_modifie" => ["Projet mis à jour", "fa-pen-to-square", "projets"],
      "projet_supprime" => ["Projet supprimé", "fa-trash", "projets"],
      "document_ajoute" => ["Document déposé", "fa-file-arrow-up", "documents"],
      "document_supprime" => ["Document supprimé", "fa-file-circle-xmark", "documents"],
      "document_telecharge" => ["Document téléchargé par le client", "fa-file-arrow-down", "documents"],
      "role_modifie" => ["Rôle modifié", "fa-user-shield", "droits"],
      "utilisateur_modifie" => ["Compte modifié (gestion complète)", "fa-user-gear", "droits"],
    ];

    //enregistre un evenement ; $login vaut par defaut l'utilisateur connecte
    public static function ajouter($type, $detail = "", $login = null){
      try {
        if($login === null) $login = $_SESSION['profil']['login'] ?? null;
        $stmt = (new self())->getBdd()->prepare("INSERT INTO journal (type, login, detail, ip) VALUES (?, ?, ?, ?)");
        $stmt->execute([$type, $login !== null ? mb_substr((string)$login, 0, 50) : null, mb_substr((string)$detail, 0, 255), self::ipAnonyme()]);
      } catch (Throwable $e) {
        error_log("Journal : ".$e->getMessage());
      }
    }

    //adresse IP tronquee (dernier octet en IPv4, fin de l'adresse en IPv6) : suffisant pour reperer
    //des tentatives repetees sans conserver l'adresse complete
    public static function ipAnonyme(){
      $ip = (string)($_SERVER['REMOTE_ADDR'] ?? "");
      if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return preg_replace('/\.\d+$/', '.0', $ip);
      if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) return implode(":", array_slice(explode(":", $ip), 0, 3))."::";
      return "";
    }

    public static function libelle($type){
      return self::TYPES[$type][0] ?? $type;
    }

    public static function icone($type){
      return self::TYPES[$type][1] ?? "fa-circle-info";
    }

    public static function categorie($type){
      return self::TYPES[$type][2] ?? "";
    }

    //types d'une categorie (filtres)
    public static function typesCategorie($categorie){
      return array_keys(array_filter(self::TYPES, function($t) use ($categorie){ return $t[2] === $categorie; }));
    }
  }
