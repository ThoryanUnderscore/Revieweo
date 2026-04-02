-- Création de la base de données
CREATE DATABASE IF NOT EXISTS revieweo;
USE revieweo;

-- Table User
CREATE TABLE IF NOT EXISTS User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pseudo VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_pseudo (pseudo),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Categorie
CREATE TABLE IF NOT EXISTS Categorie (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Critique
CREATE TABLE IF NOT EXISTS Critique (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(200) NOT NULL,
    contenu TEXT NOT NULL,
    note INT NOT NULL CHECK (note >= 0 AND note <= 10),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_user INT NOT NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_user) REFERENCES User(id) ON DELETE CASCADE,
    INDEX idx_date_creation (date_creation),
    INDEX idx_id_user (id_user),
    INDEX idx_is_pinned (is_pinned),
    INDEX idx_is_deleted (is_deleted)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Critique_Categorie (relation Many-to-Many)
CREATE TABLE IF NOT EXISTS Critique_Categorie (
    id_critique INT NOT NULL,
    id_categorie INT NOT NULL,
    PRIMARY KEY (id_critique, id_categorie),
    FOREIGN KEY (id_critique) REFERENCES Critique(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categorie) REFERENCES Categorie(id) ON DELETE CASCADE,
    INDEX idx_id_categorie (id_categorie)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table Like (relation Many-to-Many avec unique constraint)
CREATE TABLE IF NOT EXISTS Like_Critique (
    id_user INT NOT NULL,
    id_critique INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_user, id_critique),
    FOREIGN KEY (id_user) REFERENCES User(id) ON DELETE CASCADE,
    FOREIGN KEY (id_critique) REFERENCES Critique(id) ON DELETE CASCADE,
    INDEX idx_id_critique (id_critique)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion noms dans Categorie
INSERT IGNORE INTO Categorie (nom) VALUES 
('Action / Aventure'),
('FPS / TPS'),
('RPG / JRPG'),
('Survival-Horror'),
('Plateforme'),
('Simulation'),
('Stratégie / RTS'),
('Sport / Course'),
('Combat / Versus Fighting'),
('Indépendant'),
('MMORPG'),
('Roguelike / Lite'),
('Visual Novel'),
('Battle Royale');