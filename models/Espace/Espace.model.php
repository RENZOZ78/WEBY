<?php
  require_once("./models/MainManager.model.php");

  /**
   * Accès aux données de l'espace client : projets, documents, demandes et messages.
   * Utilisé côté client (filtré sur le login) et côté administration.
   */
  class EspaceManager extends MainManager{

    //etapes d'un projet, dans l'ordre
    public const ETAPES = [1 => "Devis", 2 => "En cours", 3 => "Validation", 4 => "Livré"];

    //types de projet (= prestations)
    public const TYPES = [
      "business_plan" => "Business plan",
      "creation_societe" => "Création de société",
      "gestion" => "Gestion & administratif",
      "site" => "Site internet",
      "marketing" => "Marketing & croissance",
      "autre" => "Autre",
    ];

    public const STATUTS_DEMANDE = ["nouvelle" => "Nouvelle", "en_cours" => "En cours", "traitee" => "Traitée"];

    public const CATEGORIES_DOCUMENT = [
      "devis" => "Devis", "facture" => "Facture", "contrat" => "Contrat",
      "juridique" => "Document juridique", "rapport" => "Rapport", "autre" => "Autre",
    ];

    //execute une requete preparee et renvoie le statement
    private function requete($sql, $params = []){
      $stmt = $this->getBdd()->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    }

    /* ---------- Projets ---------- */

    public function getProjetsUtilisateur($login){
      return $this->requete("SELECT * FROM projets WHERE login = ? ORDER BY updated_at DESC", [$login])->fetchAll(PDO::FETCH_ASSOC);
    }

    //tous les projets avec le mail du client (administration)
    public function getProjets(){
      return $this->requete("SELECT p.*, u.mail FROM projets p LEFT JOIN utilisateur u ON u.login = p.login ORDER BY p.updated_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    //un projet ; si $login est fourni, seulement s'il appartient a cet utilisateur
    public function getProjet($id, $login = null){
      $sql = "SELECT p.*, u.mail FROM projets p LEFT JOIN utilisateur u ON u.login = p.login WHERE p.id = ?";
      $params = [(int)$id];
      if($login !== null){ $sql .= " AND p.login = ?"; $params[] = $login; }
      $projet = $this->requete($sql, $params)->fetch(PDO::FETCH_ASSOC);
      return $projet ?: null;
    }

    public function bdCreerProjet($login, $titre, $type, $etape, $note){
      $this->requete("INSERT INTO projets (login, titre, type, etape, note) VALUES (?, ?, ?, ?, ?)", [$login, $titre, $type, (int)$etape, $note]);
      return (int)$this->getBdd()->lastInsertId();
    }

    public function bdModifierProjet($id, $titre, $type, $etape, $note){
      return $this->requete("UPDATE projets SET titre = ?, type = ?, etape = ?, note = ? WHERE id = ?", [$titre, $type, (int)$etape, $note, (int)$id])->rowCount() > 0;
    }

    public function bdSupprimerProjet($id){
      $this->requete("DELETE FROM documents WHERE projet_id = ?", [(int)$id]);
      return $this->requete("DELETE FROM projets WHERE id = ?", [(int)$id])->rowCount() > 0;
    }

    /* ---------- Documents ---------- */

    public function getDocumentsUtilisateur($login){
      return $this->requete("SELECT d.*, p.titre AS projet_titre FROM documents d LEFT JOIN projets p ON p.id = d.projet_id WHERE d.login = ? ORDER BY d.created_at DESC", [$login])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocumentsProjet($projetId){
      return $this->requete("SELECT * FROM documents WHERE projet_id = ? ORDER BY created_at DESC", [(int)$projetId])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocument($id, $login = null){
      $sql = "SELECT * FROM documents WHERE id = ?";
      $params = [(int)$id];
      if($login !== null){ $sql .= " AND login = ?"; $params[] = $login; }
      $document = $this->requete($sql, $params)->fetch(PDO::FETCH_ASSOC);
      return $document ?: null;
    }

    public function bdAjouterDocument($projetId, $login, $nom, $fichier, $categorie, $taille){
      $this->requete("INSERT INTO documents (projet_id, login, nom, fichier, categorie, taille) VALUES (?, ?, ?, ?, ?, ?)", [(int)$projetId, $login, $nom, $fichier, $categorie, (int)$taille]);
      return (int)$this->getBdd()->lastInsertId();
    }

    public function bdSupprimerDocument($id){
      return $this->requete("DELETE FROM documents WHERE id = ?", [(int)$id])->rowCount() > 0;
    }

    /* ---------- Demandes et messages ---------- */

    public function getDemandesUtilisateur($login){
      return $this->requete("SELECT d.*, (SELECT COUNT(*) FROM messages m WHERE m.demande_id = d.id) AS nb_messages FROM demandes d WHERE d.login = ? ORDER BY d.updated_at DESC", [$login])->fetchAll(PDO::FETCH_ASSOC);
    }

    //toutes les demandes, filtrees par statut si demande (administration)
    public function getDemandes($statut = ""){
      $sql = "SELECT d.*, (SELECT COUNT(*) FROM messages m WHERE m.demande_id = d.id) AS nb_messages FROM demandes d";
      $params = [];
      if($statut !== "" && isset(self::STATUTS_DEMANDE[$statut])){ $sql .= " WHERE d.statut = ?"; $params[] = $statut; }
      $sql .= " ORDER BY FIELD(d.statut, 'nouvelle', 'en_cours', 'traitee'), d.updated_at DESC";
      return $this->requete($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDemande($id, $login = null){
      $sql = "SELECT * FROM demandes WHERE id = ?";
      $params = [(int)$id];
      if($login !== null){ $sql .= " AND login = ?"; $params[] = $login; }
      $demande = $this->requete($sql, $params)->fetch(PDO::FETCH_ASSOC);
      return $demande ?: null;
    }

    public function getMessages($demandeId){
      return $this->requete("SELECT * FROM messages WHERE demande_id = ? ORDER BY created_at ASC, id ASC", [(int)$demandeId])->fetchAll(PDO::FETCH_ASSOC);
    }

    //cree la demande et son premier message ; renvoie l'id de la demande
    public function bdCreerDemande($login, $nom, $mail, $sujet, $message){
      $this->requete("INSERT INTO demandes (login, nom, mail, sujet) VALUES (?, ?, ?, ?)", [$login, $nom, $mail, $sujet]);
      $id = (int)$this->getBdd()->lastInsertId();
      $this->bdAjouterMessage($id, $nom, 0, $message);
      return $id;
    }

    public function bdAjouterMessage($demandeId, $auteur, $deAgence, $message){
      $this->requete("INSERT INTO messages (demande_id, auteur, de_agence, message) VALUES (?, ?, ?, ?)", [(int)$demandeId, $auteur, $deAgence ? 1 : 0, $message]);
      //une reponse de l'agence passe la demande "en cours", une relance du client la rouvre
      $statut = $deAgence ? "en_cours" : "nouvelle";
      $this->requete("UPDATE demandes SET statut = IF(statut = 'traitee' OR ? = 'en_cours', ?, statut), updated_at = NOW() WHERE id = ?", [$statut, $statut, (int)$demandeId]);
      return (int)$this->getBdd()->lastInsertId();
    }

    public function bdChangerStatutDemande($id, $statut){
      if(!isset(self::STATUTS_DEMANDE[$statut])) return false;
      return $this->requete("UPDATE demandes SET statut = ? WHERE id = ?", [$statut, (int)$id])->rowCount() > 0;
    }

    /* ---------- Suppression d'un compte ---------- */

    //supprime toutes les donnees liees a un login (projets, documents, demandes, messages) ; renvoie les fichiers a effacer
    public function bdSupprimerDonneesUtilisateur($login){
      $bdd = $this->getBdd();
      $fichiers = $this->requete("SELECT fichier FROM documents WHERE login = ?", [$login])->fetchAll(PDO::FETCH_COLUMN);
      $bdd->beginTransaction();
      try {
        $this->requete("DELETE FROM documents WHERE login = ?", [$login]);
        $this->requete("DELETE FROM projets WHERE login = ?", [$login]);
        $this->requete("DELETE m FROM messages m INNER JOIN demandes d ON d.id = m.demande_id WHERE d.login = ?", [$login]);
        $this->requete("DELETE FROM demandes WHERE login = ?", [$login]);
        $bdd->commit();
      } catch (Exception $e) {
        $bdd->rollBack();
        throw $e;
      }
      return $fichiers;
    }

    /* ---------- Tableaux de bord ---------- */

    //compteurs pour l'administration
    public function getStatistiques(){
      $stats = [];
      $stats['demandes_nouvelles'] = (int)$this->requete("SELECT COUNT(*) FROM demandes WHERE statut = 'nouvelle'")->fetchColumn();
      $stats['demandes_en_cours'] = (int)$this->requete("SELECT COUNT(*) FROM demandes WHERE statut = 'en_cours'")->fetchColumn();
      $stats['projets_actifs'] = (int)$this->requete("SELECT COUNT(*) FROM projets WHERE etape < 4")->fetchColumn();
      $stats['projets_livres'] = (int)$this->requete("SELECT COUNT(*) FROM projets WHERE etape = 4")->fetchColumn();
      $stats['clients'] = (int)$this->requete("SELECT COUNT(*) FROM utilisateur WHERE role = 'utilisateur'")->fetchColumn();
      $stats['documents'] = (int)$this->requete("SELECT COUNT(*) FROM documents")->fetchColumn();
      return $stats;
    }

    //liste des clients pour les formulaires (login + mail)
    public function getClients(){
      return $this->requete("SELECT login, mail, role FROM utilisateur WHERE is_valid = 1 ORDER BY login")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDernieresDemandes($limite = 5){
      return $this->requete("SELECT * FROM demandes ORDER BY updated_at DESC LIMIT ".(int)$limite)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
