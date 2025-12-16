CREATE DATABASE coachpro;
USE coachpro;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telephone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL,
    photo VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE coaches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    biographie TEXT,
    specialite VARCHAR(255),
    experience INT DEFAULT 0,
    certifications TEXT,
    prix_heure DECIMAL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE disponibilites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    coach_id INT NOT NULL,
    jour VARCHAR(20) NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    FOREIGN KEY (coach_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sportif_id INT NOT NULL,
    coach_id INT NOT NULL,
    date_seance DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    statut VARCHAR(20) DEFAULT 'en_attente',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sportif_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (coach_id) REFERENCES users(id) ON DELETE CASCADE
);
