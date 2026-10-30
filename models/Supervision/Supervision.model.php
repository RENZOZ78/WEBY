<?php
  require_once("./models/MainManager.model.php");
  require_once("./models/Supervision/Journal.class.php");
  require_once("./models/Supervision/Audience.class.php");

  /**
   * Statistiques de la supervision (super administrateur) : audience, comptes, demandes,
   * projets, documents, journal d'activite, etat technique et preferences du tableau de bord.
   */
  class SupervisionManager extends MainManager{

    private function requete($sql, $params = []){
      $stmt = $this->getBdd()->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    }

    private function valeur($sql, $params = []){
      return $this->requete($sql, $params)->fetchColumn();
    }

    //debut d'une periode de $jours jours, aujourd'hui compris
    public static function debutPeriode($jours){
      return date("Y-m-d 00:00:00", strtotime("-".((int)$jours - 1)." days"));
    }

    /* ---------- Audience ---------- */

    //pages vues et visiteurs (un visiteur = une empreinte anonyme par jour) entre deux dates
    public function getAudience($depuis, $jusqua = null){
      $jusqua = $jusqua ?? date("Y-m-d H:i:s", strtotime("+1 day"));
      $ligne = $this->requete("SELECT COUNT(*) AS vues, COUNT(DISTINCT visiteur, DATE(created_at)) AS visiteurs,
          SUM(appareil = 'mobile') AS mobiles FROM pages_vues WHERE created_at >= ? AND created_at < ?", [$depuis, $jusqua])->fetch(PDO::FETCH_ASSOC);
      return ["vues" => (int)$ligne['vues'], "visiteurs" => (int)$ligne['visiteurs'], "mobiles" => (int)$ligne['mobiles']];
    }

    //audience de la periode et de la periode precedente de meme duree (evolution)
    public function getAudienceComparee($jours){
      $debut = self::debutPeriode($jours);
      $debutPrecedent = date("Y-m-d 00:00:00", strtotime($debut." -".(int)$jours." days"));
      return ["actuelle" => $this->getAudience($debut), "precedente" => $this->getAudience($debutPrecedent, $debut)];
    }

    //serie de la periode : par jour jusqu'a 90 jours, par mois au-dela ; les jours sans visite valent 0
    public function getVisitesSerie($jours){
      $parMois = $jours > 90;
      $format = $parMois ? "%Y-%m" : "%Y-%m-%d";
      $lignes = $this->requete("SELECT DATE_FORMAT(created_at, '".$format."') AS jour, COUNT(*) AS vues,
          COUNT(DISTINCT visiteur, DATE(created_at)) AS visiteurs FROM pages_vues WHERE created_at >= ? GROUP BY jour", [self::debutPeriode($jours)])->fetchAll(PDO::FETCH_ASSOC);
      $index = array_column($lignes, null, "jour");
      $serie = [];
      $moisFr = ["janv.", "févr.", "mars", "avr.", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."];
      if($parMois){
        $debut = strtotime(date("Y-m-01", strtotime(self::debutPeriode($jours))));
        for($t = $debut; $t <= time(); $t = strtotime("+1 month", $t)){
          $cle = date("Y-m", $t);
          $serie[] = ["cle" => $cle, "libelle" => $moisFr[(int)date("n", $t) - 1]." ".date("Y", $t),
            "vues" => (int)($index[$cle]['vues'] ?? 0), "visiteurs" => (int)($index[$cle]['visiteurs'] ?? 0)];
        }
      }else{
        for($i = $jours - 1; $i >= 0; $i--){
          $t = strtotime("-".$i." days");
          $cle = date("Y-m-d", $t);
          $serie[] = ["cle" => $cle, "libelle" => (int)date("j", $t)." ".$moisFr[(int)date("n", $t) - 1],
            "vues" => (int)($index[$cle]['vues'] ?? 0), "visiteurs" => (int)($index[$cle]['visiteurs'] ?? 0)];
        }
      }
      return $serie;
    }

    //classement d'une colonne de la table pages_vues : pages par pages vues, sources et appareils par visiteurs
    public function getRepartitionVisites($colonne, $jours, $limite = 8){
      if(!in_array($colonne, ["page", "source", "appareil"], true)) return [];
      return $this->requete("SELECT ".$colonne." AS cle, COUNT(*) AS vues, COUNT(DISTINCT visiteur, DATE(created_at)) AS visiteurs
          FROM pages_vues WHERE created_at >= ? GROUP BY ".$colonne." ORDER BY ".($colonne === "page" ? "vues" : "visiteurs")." DESC LIMIT ".(int)$limite, [self::debutPeriode($jours)])->fetchAll(PDO::FETCH_ASSOC);
    }

    //pages vues par heure de la journee (0 a 23)
    public function getVisitesParHeure($jours){
      $lignes = $this->requete("SELECT HOUR(created_at) AS h, COUNT(*) AS vues FROM pages_vues WHERE created_at >= ? GROUP BY h", [self::debutPeriode($jours)])->fetchAll(PDO::FETCH_KEY_PAIR);
      $serie = [];
      for($h = 0; $h < 24; $h++) $serie[] = ["cle" => $h, "libelle" => $h."h", "vues" => (int)($lignes[$h] ?? 0)];
      return $serie;
    }

    //clics sur le telephone, le mail ou WhatsApp : visiteurs qui ont clique (une fois par jour et par type) et clics
    public function getClicsContact($jours){
      $lignes = $this->requete("SELECT type, COUNT(*) AS clics, COUNT(DISTINCT visiteur, DATE(created_at)) AS visiteurs
          FROM clics_contact WHERE created_at >= ? GROUP BY type", [self::debutPeriode($jours)])->fetchAll(PDO::FETCH_ASSOC);
      $index = array_column($lignes, null, "type");
      $types = [];
      foreach(Audience::CLICS as $type => $libelle){
        $types[$type] = ["libelle" => $libelle, "clics" => (int)($index[$type]['clics'] ?? 0), "visiteurs" => (int)($index[$type]['visiteurs'] ?? 0)];
      }
      //un visiteur qui clique sur le telephone puis sur le mail ne compte qu'une fois
      $visiteurs = (int)$this->valeur("SELECT COUNT(DISTINCT visiteur, DATE(created_at)) FROM clics_contact WHERE created_at >= ?", [self::debutPeriode($jours)]);
      return ["types" => $types, "visiteurs" => $visiteurs];
    }

    //robots et spam ecartes de l'audience : visiteurs (une empreinte par jour) et pages servies, par categorie.
    //Un "navigateur" est un robot deguise quand aucune de ses pages du jour n'a ete confirmee par le navigateur
    //(pas de JavaScript) ; une vraie personne qui repart en moins d'une seconde ou sans JavaScript y est comptee aussi.
    public function getRobots($jours){
      $nonConfirme = "(s.categorie <> 'navigateur' OR NOT EXISTS (SELECT 1 FROM pages_vues v WHERE v.visiteur = s.visiteur
          AND v.created_at >= DATE(s.created_at) AND v.created_at < DATE(s.created_at) + INTERVAL 1 DAY))";
      $depuis = self::debutPeriode($jours);
      $lignes = $this->requete("SELECT s.categorie, COUNT(*) AS pages, COUNT(DISTINCT s.visiteur, DATE(s.created_at)) AS visiteurs
          FROM pages_servies s WHERE s.created_at >= ? AND ".$nonConfirme." GROUP BY s.categorie", [$depuis])->fetchAll(PDO::FETCH_ASSOC);
      $index = array_column($lignes, null, "categorie");
      $categories = [];
      foreach(Audience::CATEGORIES_ROBOTS as $categorie => $libelle){
        $categories[$categorie] = ["libelle" => $libelle, "visiteurs" => (int)($index[$categorie]['visiteurs'] ?? 0), "pages" => (int)($index[$categorie]['pages'] ?? 0)];
      }
      //total sans doublon (un meme robot peut relever de deux categories)
      $visiteurs = (int)$this->valeur("SELECT COUNT(DISTINCT s.visiteur, DATE(s.created_at)) FROM pages_servies s WHERE s.created_at >= ? AND ".$nonConfirme, [$depuis]);
      return ["categories" => $categories, "visiteurs" => $visiteurs, "pages" => array_sum(array_column($categories, "pages"))];
    }

    //date de la premiere page vue mesuree par le navigateur (debut des chiffres fiables), null si aucune
    public function getDebutMesure(){
      $debut = $this->valeur("SELECT MIN(created_at) FROM pages_vues");
      return $debut ?: null;
    }

    //conversion : messages de contact, creations de compte et clics de contact rapportes aux visiteurs de la periode
    public function getConversion($jours){
      $depuis = self::debutPeriode($jours);
      $visiteurs = (int)$this->valeur("SELECT COUNT(DISTINCT visiteur, DATE(created_at)) FROM pages_vues WHERE created_at >= ?", [$depuis]);
      $demandes = (int)$this->valeur("SELECT COUNT(*) FROM demandes WHERE login IS NULL AND created_at >= ?", [$depuis]);
      $inscriptions = (int)$this->valeur("SELECT COUNT(*) FROM journal WHERE type = 'inscription' AND created_at >= ?", [$depuis]);
      $clics = $this->getClicsContact($jours)['visiteurs'];
      return ["visiteurs" => $visiteurs, "demandes" => $demandes, "inscriptions" => $inscriptions, "clics" => $clics,
        "taux" => $visiteurs > 0 ? round(($demandes + $inscriptions + $clics) * 100 / $visiteurs, 1) : null];
    }

    /* ---------- Comptes ---------- */

    public function getStatsComptes($jours){
      $roles = $this->requete("SELECT role, COUNT(*) FROM utilisateur GROUP BY role")->fetchAll(PDO::FETCH_KEY_PAIR);
      $depuis = self::debutPeriode($jours);
      return [
        "total" => array_sum(array_map("intval", $roles)),
        "roles" => $roles,
        "non_valides" => (int)$this->valeur("SELECT COUNT(*) FROM utilisateur WHERE is_valid = 0"),
        "inscriptions" => (int)$this->valeur("SELECT COUNT(*) FROM journal WHERE type = 'inscription' AND created_at >= ?", [$depuis]),
        "connexions" => (int)$this->valeur("SELECT COUNT(*) FROM journal WHERE type = 'connexion' AND created_at >= ?", [$depuis]),
        "actifs" => (int)$this->valeur("SELECT COUNT(DISTINCT login) FROM journal WHERE type = 'connexion' AND created_at >= ?", [$depuis]),
      ];
    }

    //tous les comptes avec leur activite (derniere connexion, projets, demandes, documents)
    public function getComptes($jours){
      return $this->requete("SELECT u.login, u.mail, u.role, u.is_valid,
          (SELECT MAX(j.created_at) FROM journal j WHERE j.login = u.login AND j.type = 'connexion') AS derniere_connexion,
          (SELECT COUNT(*) FROM journal j WHERE j.login = u.login AND j.type = 'connexion' AND j.created_at >= ?) AS connexions,
          (SELECT COUNT(*) FROM journal j WHERE j.login = u.login AND j.type = 'connexion_echec' AND j.created_at >= ?) AS echecs,
          (SELECT COUNT(*) FROM projets p WHERE p.login = u.login) AS projets,
          (SELECT COUNT(*) FROM demandes d WHERE d.login = u.login) AS demandes,
          (SELECT COUNT(*) FROM documents d WHERE d.login = u.login) AS documents
        FROM utilisateur u ORDER BY derniere_connexion IS NULL, derniere_connexion DESC, u.login", [self::debutPeriode($jours), self::debutPeriode($jours)])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoleUtilisateur($login){
      $role = $this->valeur("SELECT role FROM utilisateur WHERE login = ?", [$login]);
      return $role === false ? null : $role;
    }

    /* ---------- Demandes ---------- */

    public function getStatsDemandes($jours){
      $depuis = self::debutPeriode($jours);
      $delai = $this->valeur("SELECT AVG(TIMESTAMPDIFF(MINUTE, d.created_at,
          (SELECT MIN(m.created_at) FROM messages m WHERE m.demande_id = d.id AND m.de_agence = 1))) FROM demandes d WHERE d.created_at >= ?", [$depuis]);
      return [
        "statuts" => $this->requete("SELECT statut, COUNT(*) FROM demandes GROUP BY statut")->fetchAll(PDO::FETCH_KEY_PAIR),
        "periode" => (int)$this->valeur("SELECT COUNT(*) FROM demandes WHERE created_at >= ?", [$depuis]),
        "contact" => (int)$this->valeur("SELECT COUNT(*) FROM demandes WHERE login IS NULL AND created_at >= ?", [$depuis]),
        "clients" => (int)$this->valeur("SELECT COUNT(*) FROM demandes WHERE login IS NOT NULL AND created_at >= ?", [$depuis]),
        "delai_minutes" => $delai === null ? null : (int)round((float)$delai),
        "sans_reponse_48h" => (int)$this->valeur("SELECT COUNT(*) FROM demandes WHERE statut = 'nouvelle' AND updated_at < ?", [date("Y-m-d H:i:s", strtotime("-48 hours"))]),
      ];
    }

    public function getDemandesEnAttente($limite = 5){
      return $this->requete("SELECT * FROM demandes WHERE statut = 'nouvelle' ORDER BY updated_at ASC LIMIT ".(int)$limite)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- Projets et documents ---------- */

    public function getStatsProjets(){
      return [
        "etapes" => $this->requete("SELECT etape, COUNT(*) FROM projets GROUP BY etape")->fetchAll(PDO::FETCH_KEY_PAIR),
        "types" => $this->requete("SELECT type, COUNT(*) AS nb FROM projets GROUP BY type ORDER BY nb DESC")->fetchAll(PDO::FETCH_KEY_PAIR),
        "total" => (int)$this->valeur("SELECT COUNT(*) FROM projets"),
        "sans_nouvelles" => (int)$this->valeur("SELECT COUNT(*) FROM projets WHERE etape < 4 AND updated_at < ?", [date("Y-m-d H:i:s", strtotime("-30 days"))]),
      ];
    }

    public function getStatsDocuments($jours){
      $ligne = $this->requete("SELECT COUNT(*) AS nb, COALESCE(SUM(taille), 0) AS taille FROM documents")->fetch(PDO::FETCH_ASSOC);
      $depuis = self::debutPeriode($jours);
      return [
        "total" => (int)$ligne['nb'],
        "taille" => (int)$ligne['taille'],
        "deposes" => (int)$this->valeur("SELECT COUNT(*) FROM documents WHERE created_at >= ?", [$depuis]),
        "telecharges" => (int)$this->valeur("SELECT COUNT(*) FROM journal WHERE type = 'document_telecharge' AND created_at >= ?", [$depuis]),
      ];
    }

    /* ---------- Journal d'activite ---------- */

    //evenements filtres (categorie, login, periode) ; renvoie [lignes, total]
    public function getJournal($categorie = "", $login = "", $jours = 30, $page = 1, $parPage = 50){
      $where = ["created_at >= ?"];
      $params = [self::debutPeriode($jours)];
      if($categorie !== "" && isset(Journal::CATEGORIES[$categorie])){
        $types = Journal::typesCategorie($categorie);
        $where[] = "type IN (".implode(",", array_fill(0, count($types), "?")).")";
        $params = array_merge($params, $types);
      }
      if($login !== ""){
        $where[] = "login = ?";
        $params[] = $login;
      }
      $condition = " WHERE ".implode(" AND ", $where);
      $total = (int)$this->valeur("SELECT COUNT(*) FROM journal".$condition, $params);
      $decalage = (max(1, (int)$page) - 1) * (int)$parPage;
      $lignes = $this->requete("SELECT * FROM journal".$condition." ORDER BY created_at DESC, id DESC LIMIT ".(int)$parPage." OFFSET ".$decalage, $params)->fetchAll(PDO::FETCH_ASSOC);
      return [$lignes, $total];
    }

    public function getDernierEvenements($limite = 8){
      return $this->requete("SELECT * FROM journal ORDER BY created_at DESC, id DESC LIMIT ".(int)$limite)->fetchAll(PDO::FETCH_ASSOC);
    }

    //echecs de connexion recents, regroupes par adresse (tronquee) : repere les tentatives repetees
    public function getEchecsConnexion($heures = 24){
      return $this->requete("SELECT ip, COUNT(*) AS nb, MAX(created_at) AS dernier, GROUP_CONCAT(DISTINCT REPLACE(detail, 'login essayé : ', '') SEPARATOR ', ') AS logins
          FROM journal WHERE type = 'connexion_echec' AND created_at >= ? GROUP BY ip ORDER BY nb DESC LIMIT 10", [date("Y-m-d H:i:s", strtotime("-".(int)$heures." hours"))])->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- Etat technique ---------- */

    public function getSysteme(){
      $tables = $this->requete("SELECT TABLE_NAME AS nom, TABLE_ROWS AS lignes, (DATA_LENGTH + INDEX_LENGTH) AS taille
          FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_ASSOC);
      //nombre exact de lignes (TABLE_ROWS n'est qu'une estimation pour InnoDB)
      foreach($tables as &$table){
        if(preg_match('/^[A-Za-z0-9_]+$/', $table['nom'])) $table['lignes'] = (int)$this->valeur("SELECT COUNT(*) FROM `".$table['nom']."`");
      }
      unset($table);
      return [
        "php" => PHP_VERSION,
        "base" => (string)$this->valeur("SELECT VERSION()"),
        "tables" => $tables,
        "taille_base" => array_sum(array_column($tables, "taille")),
      ];
    }

    /* ---------- Preferences ---------- */

    public function getPreference($login, $cle){
      $valeur = $this->valeur("SELECT valeur FROM preferences WHERE login = ? AND cle = ?", [$login, $cle]);
      return $valeur === false ? null : $valeur;
    }

    public function setPreference($login, $cle, $valeur){
      $this->requete("INSERT INTO preferences (login, cle, valeur) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE valeur = VALUES(valeur)", [$login, $cle, $valeur]);
    }

    public function supprimerPreference($login, $cle){
      $this->requete("DELETE FROM preferences WHERE login = ? AND cle = ?", [$login, $cle]);
    }
  }
