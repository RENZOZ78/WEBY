-- Schéma de la base WebyCloudy (MySQL / MariaDB)
-- Import : mysql -u root webycloudy < database.sql   (ou via phpMyAdmin)
-- Les tables sont créées seulement si elles n'existent pas : le script peut être rejoué sans risque.

CREATE DATABASE IF NOT EXISTS webycloudy CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE webycloudy;

-- Comptes (clients, administrateurs, super administrateur)
CREATE TABLE IF NOT EXISTS utilisateur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  mail VARCHAR(150) NOT NULL,
  is_valid TINYINT(1) NOT NULL DEFAULT 0,
  role VARCHAR(30) NOT NULL DEFAULT 'utilisateur',
  clef INT NOT NULL DEFAULT 0,
  image VARCHAR(255) NOT NULL DEFAULT 'profils/profil.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Projets suivis dans l'espace client (un projet = une prestation vendue à un client)
-- etape : 1 = devis, 2 = en cours, 3 = validation, 4 = livré
CREATE TABLE IF NOT EXISTS projets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(50) NOT NULL,
  titre VARCHAR(150) NOT NULL,
  type VARCHAR(40) NOT NULL DEFAULT 'autre',
  etape TINYINT NOT NULL DEFAULT 1,
  note TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_projets_login (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Documents déposés par l'agence pour un client (devis, factures, statuts, rapports…)
CREATE TABLE IF NOT EXISTS documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  projet_id INT NOT NULL,
  login VARCHAR(50) NOT NULL,
  nom VARCHAR(150) NOT NULL,
  fichier VARCHAR(255) NOT NULL,
  categorie VARCHAR(30) NOT NULL DEFAULT 'autre',
  taille INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_documents_projet (projet_id),
  INDEX idx_documents_login (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Demandes : formulaire de contact (login NULL) et demandes des clients connectés
-- statut : nouvelle, en_cours, traitee
CREATE TABLE IF NOT EXISTS demandes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(50) NULL,
  nom VARCHAR(100) NOT NULL,
  mail VARCHAR(150) NOT NULL,
  sujet VARCHAR(150) NOT NULL,
  statut VARCHAR(20) NOT NULL DEFAULT 'nouvelle',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_demandes_login (login),
  INDEX idx_demandes_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Fil de messages d'une demande (client / visiteur d'un côté, agence de l'autre)
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  demande_id INT NOT NULL,
  auteur VARCHAR(100) NOT NULL,
  de_agence TINYINT(1) NOT NULL DEFAULT 0,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_messages_demande (demande_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Mesure d'audience (supervision) : une ligne par page publique vue.
-- Aucune adresse IP n'est conservée : "visiteur" est une empreinte anonyme qui change chaque jour.
CREATE TABLE IF NOT EXISTS visites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page VARCHAR(120) NOT NULL,
  visiteur CHAR(16) NOT NULL,
  source VARCHAR(80) NOT NULL DEFAULT 'direct',
  appareil VARCHAR(12) NOT NULL DEFAULT 'ordinateur',
  connecte TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_visites_date (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Journal d'activité (supervision) : connexions, comptes, demandes, projets, documents, droits
CREATE TABLE IF NOT EXISTS journal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(40) NOT NULL,
  login VARCHAR(50) NULL,
  detail VARCHAR(255) NOT NULL DEFAULT '',
  ip VARCHAR(45) NOT NULL DEFAULT '',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_journal_date (created_at),
  INDEX idx_journal_type (type),
  INDEX idx_journal_login (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Préférences d'un compte (ex. : widgets du tableau de bord de supervision)
CREATE TABLE IF NOT EXISTS preferences (
  login VARCHAR(50) NOT NULL,
  cle VARCHAR(50) NOT NULL,
  valeur TEXT NOT NULL,
  PRIMARY KEY (login, cle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
