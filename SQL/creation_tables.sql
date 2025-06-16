DROP TABLE IF EXISTS TempJeux;

CREATE TABLE TempJeux (
    id_jeu INT,
    titre_jeu VARCHAR(255),
    ref VARCHAR(255),
    auteurs VARCHAR(500),
    date_parution_debut YEAR ,
    date_parution_fin YEAR,
    information_date VARCHAR(255),
    version VARCHAR(100),
    nombre_joueurs VARCHAR(50),
    age_min VARCHAR(50),
    mots_cles TEXT,
    num_boite INT,
    localisation_cnj VARCHAR(255),
    mecanisme1 VARCHAR(255),
    mecanisme2 VARCHAR(255),
    mecanisme3 VARCHAR(255),
    collection_origine VARCHAR(255),
    etat VARCHAR(255),
    code_barre VARCHAR(255)
);

LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 9.1/Uploads/inventaire.csv'
INTO TABLE TempJeux
FIELDS TERMINATED BY ','    -- Délimiteur des champs (ici la virgule)
ENCLOSED BY '"'             -- Si les champs sont entre guillemets (optionnel)
LINES TERMINATED BY '\n'    -- Délimiteur des lignes (retour à la ligne)
IGNORE 1 LINES
(@id_jeu, @titre_jeu, @ref, @auteurs, @date_parution_debut, @date_parution_fin, @information_date, 
@version, @nombre_joueurs, @age_min, @mots_cles, @num_boite, @localisation_cnj, @mecanisme1, 
@mecanisme2, @mecanisme3, @collection_origine, @etat, @code_barre)
SET 
	id_jeu = NULLIF(@id_jeu, ''),  -- Si l'ID du jeu est vide, le convertir en NULL
    titre_jeu = NULLIF(@titre_jeu, ''),  -- Si le titre est vide, le convertir en NULL
    date_parution_debut = NULLIF(@date_parution_debut, ''),
    date_parution_fin = NULLIF(@date_parution_fin, ''),
    ref = NULLIF(@ref, ''),
    auteurs = NULLIF(@auteurs, ''),
    information_date = NULLIF(@information_date, ''),
    version = NULLIF(@version, ''),
    nombre_joueurs = NULLIF(@nombre_joueurs, ''),
    age_min = NULLIF(@age_min, ''),
    mots_cles = NULLIF(@mots_cles, ''),
    num_boite = NULLIF(@num_boite, ''),
    localisation_cnj = NULLIF(@localisation_cnj, ''),
    mecanisme1 = NULLIF(@mecanisme1, ''),
    mecanisme2 = NULLIF(@mecanisme2, ''),
    mecanisme3 = NULLIF(@mecanisme3, ''),
    collection_origine = NULLIF(@collection_origine, ''),
    etat = NULLIF(@etat, ''),
    code_barre = NULLIF(@code_barre, '');


-- Désactiver temporairement les vérifications des clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Supprimer les tables existantes
DROP TABLE IF EXISTS jeu_mecanisme;
DROP TABLE IF EXISTS jeu_categorie;
DROP TABLE IF EXISTS jeu_auteur;
DROP TABLE IF EXISTS jeu_editeur;
DROP TABLE IF EXISTS pret;
DROP TABLE IF EXISTS boite;
DROP TABLE IF EXISTS jeu;
DROP TABLE IF EXISTS emprunteur;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS localisation;
DROP TABLE IF EXISTS collection;
DROP TABLE IF EXISTS mecanisme;
DROP TABLE IF EXISTS editeur;
DROP TABLE IF EXISTS auteur;
DROP TABLE IF EXISTS categorie;

-- Réactiver les vérifications des clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

-- Création des tables

CREATE TABLE utilisateur (
    utilisateur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Gestionnaire', 'Utilisateur') NOT NULL,
    telephone VARCHAR(20),
    adresse TEXT,
    date_naissance DATE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE emprunteur (
    emprunteur_id INT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    telephone VARCHAR(20),
    adresse TEXT,
    date_naissance DATE,
    FOREIGN KEY (emprunteur_id) REFERENCES utilisateur(utilisateur_id)
);


CREATE TABLE mecanisme (
    mecanisme_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE localisation (
    localisation_id INT AUTO_INCREMENT PRIMARY KEY,
    salle VARCHAR(100) NOT NULL,
    etagere VARCHAR(100)
);

CREATE TABLE collection (
    collection_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE editeur (
    editeur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE auteur (
    auteur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE jeu (
    id_jeu INT AUTO_INCREMENT PRIMARY KEY,
    identifiant INT,
    titre VARCHAR(255) NOT NULL,
    date_parution_debut YEAR,
    date_parution_fin YEAR,
    information_date VARCHAR(255),
    version VARCHAR(100),
    nombre_de_joueurs VARCHAR(50),
    age_indique VARCHAR(50),
    mots_cles TEXT,
    mecanisme_id INT,
    FOREIGN KEY (mecanisme_id) REFERENCES mecanisme(mecanisme_id)
);

CREATE TABLE boite (
    id_boite INT AUTO_INCREMENT PRIMARY KEY,
    jeu_id INT NOT NULL,
    etat VARCHAR(50),
    localisation_id INT NOT NULL,
    code_barre VARCHAR(100),
    collection_id INT,
    FOREIGN KEY (jeu_id) REFERENCES jeu(id_jeu),
    FOREIGN KEY (localisation_id) REFERENCES localisation(localisation_id),
    FOREIGN KEY (collection_id) REFERENCES collection(collection_id)
);

CREATE TABLE pret (
    id_pret INT AUTO_INCREMENT PRIMARY KEY,
    emprunteur_id INT NOT NULL,
    id_boite INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    FOREIGN KEY (emprunteur_id) REFERENCES emprunteur(emprunteur_id),
    FOREIGN KEY (id_boite) REFERENCES boite(id_boite)
);

CREATE TABLE jeu_categorie (
    id_jeu INT NOT NULL,
    id_categorie INT NOT NULL,
    PRIMARY KEY (id_jeu, id_categorie),
    FOREIGN KEY (id_jeu) REFERENCES jeu(id_jeu),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie)
);

CREATE TABLE jeu_auteur (
    id_jeu INT NOT NULL,
    auteur_id INT NOT NULL,
    PRIMARY KEY (id_jeu, auteur_id),
    FOREIGN KEY (id_jeu) REFERENCES jeu(id_jeu),
    FOREIGN KEY (auteur_id) REFERENCES auteur(auteur_id)
);

CREATE TABLE jeu_editeur (
    id_jeu INT NOT NULL,
    editeur_id INT NOT NULL,
    PRIMARY KEY (id_jeu, editeur_id),
    FOREIGN KEY (id_jeu) REFERENCES jeu(id_jeu),
    FOREIGN KEY (editeur_id) REFERENCES editeur(editeur_id)
);

CREATE TABLE jeu_mecanisme (
    id_jeu INT NOT NULL,
    id_mecanisme INT NOT NULL,
    PRIMARY KEY (id_jeu, id_mecanisme),
    FOREIGN KEY (id_jeu) REFERENCES jeu(id_jeu),
    FOREIGN KEY (id_mecanisme) REFERENCES mecanisme(mecanisme_id)
);
