-- Schéma de la base WebyCloudy (MySQL / MariaDB)
-- Import : mysql -u root webycloudy < database.sql   (ou via phpMyAdmin)
-- Reconstitué à partir du code : adaptez-le si votre base locale contient d'autres colonnes.

CREATE DATABASE IF NOT EXISTS webycloudy CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE webycloudy;

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

CREATE TABLE IF NOT EXISTS produits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  designation VARCHAR(150) NOT NULL,
  prix DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS commandes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(50) NOT NULL,
  produit_id INT NOT NULL,
  date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
