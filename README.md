# SAE4.01 : Développement d'une application de gestion de collection de jeux

## 🎯 Aperçu du projet

L'Université Sorbonne Paris Nord possède une collection exceptionnelle de plus de 17 000 jeux de société, certains datant du XIXe siècle. Ce projet vise à concevoir une application web complète accompagnée de scripts pour gérer, organiser, et valoriser cette collection unique.

![Aperçu du site](archive/App/assets/images/site-demo.gif)

---

<<<<<<< develop
## Contexte
L'Université Sorbonne Paris Nord possède une collection exceptionnelle de plus de 17 000 jeux de société, certains datant du XIXe siècle. Ce projet vise à concevoir une application web accompagnée de scripts pour gérer, organiser, et valoriser cette collection.


## Nouveaux ajouts et améliorations

Au cours du projet, plusieurs ajouts et améliorations ont été réalisés afin de le finaliser :

- Refonte du style du site
- Ajustement de la base de données pour la gestion de l’historique
- Export de données
- Suivi des prêts
- Ajout de la localisation physique
- Ajout de filtre de recherche pour le suivi de prêt
- Ajout d’une barre de recherche dans le panneau d’administration

## Fonctionnalités principales
- **Nettoyage des données** : Correction des incohérences dans les fichiers Excel.
- **Base de données relationnelle** : Organisation structurée des informations.
- **Interface web** : Recherche avancée, gestion des prêts, et gestion de l’inventaire.
- **Scripts Python** : Manipulation automatisée des données.

--- 

## Structure du projet
```plaintext
SAE3.01-main/
├── app/              # Site web principal (MVC)
├── sql/              # Scripts SQL pour la base de données
├── scripts/          # Scripts Python et fichiers de données
├── archive/          # Prototype initial en HTML
├── README.md         # Documentation principale
```
=======
## 🚀 Fonctionnalités principales

### 📊 Gestion de l'inventaire

- **Recherche avancée** : Recherche multicritères (titre, auteur, mécanisme, catégorie, etc.)
- **Gestion des jeux** : Ajout, modification et suppression de jeux
- **Localisation physique** : Suivi de l'emplacement des boîtes de jeux
- **Gestion des états** : Suivi de l'état de conservation des jeux

### 👥 Gestion des utilisateurs

- **Système d'authentification** : Connexion/inscription sécurisée
- **Gestion des rôles** : Admin, Gestionnaire, Utilisateur
- **Profils utilisateurs** : Gestion des informations personnelles
- **Mon compte** : Interface personnalisée pour chaque utilisateur

### 📚 Gestion des prêts

- **Système de réservation** : Emprunt et retour de jeux
- **Suivi des prêts** : Historique complet des emprunts
- **Gestion des retards** : Suivi des retours en retard
- **Historique des actions** : Traçabilité complète des opérations

### 🔧 Administration

- **Panneau d'administration** : Interface dédiée aux administrateurs
- **Gestion des utilisateurs** : Création, modification, suppression
- **Gestion des réservations** : Validation et suivi des prêts
- **Barre de recherche** : Recherche rapide dans l'administration

### 📈 Export et rapports

- **Export Excel** : Génération de rapports au format Excel
- **Scripts Python** : Automatisation des tâches de nettoyage
- **Données structurées** : Export des données de la collection
>>>>>>> main

---

## 🏗️ Architecture technique

### Structure MVC (Model-View-Controller)

```
app/
├── Controllers/          # Logique métier
│   ├── Controller.php                    # Contrôleur principal
│   ├── Controller_administration.php     # Gestion administration
│   ├── Controller_connexion_inscription.php # Authentification
│   ├── Controller_exportation.php        # Export de données
│   ├── Controller_historique.php         # Historique des actions
│   ├── Controller_home.php               # Page d'accueil
│   ├── Controller_list.php               # Liste des jeux
│   ├── Controller_monCompte.php          # Gestion du compte
│   ├── Controller_recherche.php          # Recherche avancée
│   └── Controller_set.php                # Configuration
├── Models/              # Accès aux données
│   └── Model.php                        # Modèle principal
├── Views/               # Interface utilisateur
│   ├── view_administration.php          # Panneau admin
│   ├── view_connexion_inscription.php   # Page de connexion
│   ├── view_historique.php              # Historique
│   ├── view_home.php                    # Accueil
│   ├── view_liste_jeuPopulaire.php      # Liste des jeux
│   ├── view_monCompte.php               # Mon compte
│   ├── view_rechercheAvancee.php        # Recherche
│   └── ...                              # Autres vues
├── Content/             # Ressources statiques
│   ├── css/                             # Styles CSS
│   └── img/                             # Images
└── identifiants/        # Configuration BDD
    └── identifiant.php                  # Paramètres de connexion
```

### Base de données relationnelle

- **Tables principales** : `jeu`, `boite`, `utilisateur`, `emprunteur`, `pret`
- **Tables de liaison** : `jeu_auteur`, `jeu_categorie`, `jeu_editeur`, `jeu_mecanisme`
- **Tables de référence** : `auteur`, `categorie`, `editeur`, `mecanisme`, `localisation`, `collection`
- **Traçabilité** : `historique` pour le suivi des actions

---

## 🛠️ Installation et configuration

### Prérequis système

- **Serveur web** : [XAMPP](https://www.apachefriends.org/index.html) (Apache + MySQL)
- **Python** : Version 3.x avec `pip`
- **MySQL** : Version 8.0 ou 9.1
- **Navigateur web** : Chrome, Firefox, Safari, Edge

### 📋 Étapes d'installation

#### 1. Téléchargement du projet

```bash
# Cloner le dépôt
git clone https://github.com/votre_projet/SAE4.01-Developpement-d-une-application-develop.git

# Ou télécharger et extraire l'archive ZIP
```

#### 2. Configuration de la base de données

**a) Préparer le fichier d'inventaire**

- Placez le fichier `inventaire.csv` dans le répertoire MySQL :
  ```
  C:/ProgramData/MySQL/MySQL Server <VERSION>/Uploads/inventaire.csv
  ```

**b) Créer la base de données**

- Ouvrez phpMyAdmin ou MySQL Workbench
- Importez le fichier `SQL/creation_tables.sql`
- **Important** : Modifiez le chemin du fichier CSV dans le script :
  ```sql
  LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 9.1/Uploads/inventaire.csv'
  INTO TABLE TempJeux
  ```

**c) Insérer les données**

- Importez le fichier `SQL/script_insertion.sql`

**d) Configurer la connexion**

- Modifiez `app/identifiants/identifiant.php` :
  ```php
  <?php
  $dsn = 'mysql:host=localhost;dbname=nom_de_votre_bdd';
  $host = 'localhost';
  $username = 'votre_utilisateur';
  $password = 'votre_mot_de_passe';
  $database = 'nom_de_votre_bdd';
  ?>
  ```

#### 3. Configuration du serveur web

**a) Placer l'application**

- Copiez le dossier `app/` dans `C:/xampp/htdocs/`

**b) Démarrer les services**

- Lancez XAMPP Control Panel
- Démarrez Apache et MySQL
- Accédez à l'application : `http://localhost/app/`

#### 4. Configuration des scripts Python

**a) Installer les dépendances**

```bash
cd scripts/scripts_nettoyage/
pip install pandas openpyxl
```

**b) Tester les scripts**

```bash
python main.py
```

---

## 🔧 Utilisation

### 👤 Première connexion

1. Accédez à `http://localhost/app/`
2. Cliquez sur "Connexion/Inscription"
3. Créez un compte ou connectez-vous
4. Pour l'administration, utilisez un compte avec le rôle "Admin"

### 🔍 Recherche de jeux

- **Recherche simple** : Barre de recherche sur la page d'accueil
- **Recherche avancée** : Filtres par auteur, mécanisme, catégorie, etc.
- **Liste complète** : Consultation de tous les jeux avec pagination

### 📚 Gestion des prêts

1. Connectez-vous avec un compte utilisateur
2. Recherchez le jeu souhaité
3. Cliquez sur "Emprunter"
4. Les administrateurs peuvent gérer les retours

### ⚙️ Administration

- **Gestion des utilisateurs** : Création et modification des comptes
- **Gestion des prêts** : Validation et suivi des emprunts
- **Export de données** : Génération de rapports Excel

---

<<<<<<< develop
#### 2. Préparer la base de données
1. **Importer l'inventaire fictif** :
   - Déplacez le fichier `inventaire.csv` dans le répertoire suivant (selon la version MySQL installée) :
     ```
     C:/ProgramData/MySQL/MySQL Server <VERSION>/Uploads/inventaire.csv
     ```
   - Assurez-vous que le fichier est accessible dans ce dossier.

2. **Exécuter le script de création des tables** :
   - Ouvrez votre interface de gestion MySQL (ex. phpMyAdmin ou ligne de commande).
   - Importez le fichier `sql/creation_tables.sql` dans votre base de données.
   - **Remarque importante** : Modifiez la localisation du fichier `inventaire.csv` dans le script pour refléter l'emplacement exact de votre fichier. 
   Exemple :
     ```sql
     LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/inventaire.csv'
     INTO TABLE ...
     ```

3. **Insérer les données** :
   - Importez ensuite les scripts d'insertion `sql/script_insertion.sql`.

4. **Configurer le fichier `identifiant.php`** :
   - Ouvrez le fichier `app/identifiants/identifiant.php`.
   - Remplacez les informations par celles correspondant à votre environnement :
     ```php
     <?php

     $dsn = 'mysql:host=localhost;dbname=NomDeVotreBDD';
     $username = 'VotreNomUtilisateur';
     $password = 'VotreMotDePasse';

     ?>
     ```
=======
## 📁 Structure complète du projet

```
SAE4.01-Developpement-d-une-application-develop/
├── app/                          # Application web principale
│   ├── Controllers/              # Contrôleurs MVC
│   ├── Models/                   # Modèles de données
│   ├── Views/                    # Vues et templates
│   ├── Content/                  # Ressources statiques
│   ├── identifiants/             # Configuration BDD
│   └── scripts/                  # Scripts d'exportation
├── SQL/                          # Scripts de base de données
│   ├── creation_tables.sql       # Création des tables
│   └── script_insertion.sql      # Insertion des données
├── scripts/                      # Scripts Python
│   ├── data/                     # Données et exports
│   └── scripts_nettoyage/        # Nettoyage des données
├── archive/                      # Prototypes et versions précédentes
└── README.md                     # Documentation principale
```
>>>>>>> main

---

## 🐛 Dépannage

### Problèmes courants

**Erreur de connexion à la base de données**

- Vérifiez les paramètres dans `identifiant.php`
- Assurez-vous que MySQL est démarré
- Vérifiez les permissions utilisateur

**Fichier CSV non trouvé**

- Vérifiez le chemin dans `creation_tables.sql`
- Assurez-vous que le fichier est dans le bon répertoire MySQL

**Script Python ne fonctionne pas**

- Vérifiez l'installation de Python
- Installez les dépendances : `pip install pandas openpyxl`
- Vérifiez les permissions d'exécution

**Page blanche ou erreur 500**

- Vérifiez les logs d'erreur Apache
- Assurez-vous que PHP est activé dans XAMPP
- Vérifiez la syntaxe PHP

---

## 🛡️ Technologies utilisées

### Backend

- **PHP** : Langage principal de l'application
- **MySQL** : Base de données relationnelle
- **Architecture MVC** : Organisation du code

### Frontend

- **HTML5** : Structure des pages
- **CSS3** : Styles et mise en page
- **JavaScript** : Interactions utilisateur

### Scripts et outils

- **Python 3.x** : Scripts de nettoyage et export
- **Pandas** : Manipulation des données
- **OpenPyXL** : Génération de fichiers Excel

### Serveur

- **Apache** : Serveur web
- **XAMPP** : Environnement de développement

---

## 👥 Équipe du projet

- **[Lasry BESKIWIN](https://github.com/Lasryy)**
- **[Rania BOUSFIHA](https://github.com/rania212)**
- **[Safiya NGUYEN](https://github.com/safiya-ng)**
- **[Ahash PARTHIPAN](https://github.com/AhashPARTHIPAN)**
- **[Jules RICHARDOT](https://github.com/JulesRichardot)**

---

## 📄 Licence

Ce projet est développé dans le cadre de la SAE4.01 de l'Université Sorbonne Paris Nord.

---

_Dernière mise à jour : Juin 2025_
