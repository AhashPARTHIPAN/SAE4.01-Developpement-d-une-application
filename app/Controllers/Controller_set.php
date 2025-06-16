<?php

class Controller_set extends Controller
{

    public function action_default()
    {
        $this->action_form_add();
    }

    // ----------------------------- DEBUT UPDATE ----------------------------- //
    public function action_form_update()
    {
        $in_database = false;
        if (isset($_GET["id_jeu"]) && preg_match("/^[1-9]\d*$/", $_GET["id_jeu"])) {
            $m = Model::getModel();
            $in_database = $m->getJeuParId($_GET["id_jeu"]) !== False; // Vérification de l'existence du jeu dans la base de données
        }

        if ($in_database) {
            // Récupération des informations du jeu
            $informations = $m->getInformationsDuJeu($_GET["id_jeu"]);  // Méthode qui récupère les infos du jeu en fonction de l'ID

            // Préparation de $data avec les informations récupérées
            $data = [];
            foreach ($informations as $c => $v) {
                if ($v === null) {
                    $data[$c] = "";  // Si la donnée est vide, on la transforme en chaîne vide
                } else {
                    $data[$c] = $v;
                }
            }

            // Affichage du formulaire de mise à jour
            $this->render("form_update", $data);  // Appel du modèle de vue pour afficher le formulaire avec les données
        } else {
            // Si l'ID du jeu n'existe pas dans la base de données, afficher un message d'erreur
            $this->action_error("There is no game with such ID!!! It cannot be updated!!!");
        }
    }

    public function action_update(){
        $in_database = false;
        if (isset($_POST["id_jeu"]) && preg_match("/^[1-9]\d*$/", $_POST["id_jeu"])
            && isset($_POST["titre_jeu"]) && !preg_match("/^_*$/", $_POST["titre_jeu"])
            && isset($_POST["date_parution_debut"]) && preg_match("/^[12]\d{3}$/", $_POST["date_parution_debut"])
        ) {
            $m = Model::getModel();
            $in_database = $m->getJeuParId($_POST["id_jeu"]) !== false;
        }

        if ($in_database) {
            // Préparation des données pour la mise à jour
            $infos = [
                'id_jeu' => $_POST['id_jeu'],
                'titre_jeu' => $_POST['titre_jeu'],
                'date_parution_debut' => $_POST['date_parution_debut'],
                'date_parution_fin' => $_POST['date_parution_fin'],
                'information_date' => $_POST['information_date'],
                'version' => $_POST['version'],
                'nombre_joueurs' => $_POST['nombre_joueurs'],
                'age_min' => $_POST['age_min'],
                'mots_cles' => $_POST['mots_cles'],
            ];

            // Appel de la méthode update
            $m->updateInfosJeu($infos);

            $message = "Le jeu a bien été mis à jour.";
        } else {
            $message = "Il n'y a pas de jeu à mettre à jour avec cet ID.";
        }

        // Affichage du message de confirmation
        $data = [
            "title" => "Mise à jour du jeu",
            "message" => $message,
        ];
        $this->render("message", $data);
    }

    // ----------------------------- FIN UPDATE ----------------------------- //

    // ----------------------------- DEBUT REMOVE ----------------------------- //

    public function action_remove()
    {
        if (isset($_GET["id_jeu"]) and preg_match("/^[1-9]\d*$/", $_GET["id_jeu"])) {
            $id = $_GET["id_jeu"];

            $m = Model::getModel();
            $suppression = $m->removeJeuParId($id);
            if ($suppression) {
                $message = "Le jeu a été supprimé.";
            } else {
                $message = "Il n'y a pas de jeu avec l'identifiant :  " . $id . " !";
            }
        } else {
            $message = "There is no id in the URL!";
        }

        $data = [
            "title" => "Suppression du jeu",
            "message" => $message,
        ];
        $this->render("message", $data);
    }

    // ----------------------------- FIN REMOVE ----------------------------- //

    // ----------------------------- DEBUT ADD ----------------------------- //

    public function action_form_add() {
        // Vérification des catégories, auteurs, éditeurs et mécanismes
        $m = Model::getModel();
    
        // Récupération des listes nécessaires à l'affichage du formulaire
        $data = [
            "categories" => $m->getIdOfCategories(),
            "auteurs" => $m->getAuteurs(),
            "editeurs" => $m->getEditeurs(),
            "mecanismes" => $m->getMecanismes(),
        ];
    
        // Affichage du formulaire d'ajout de jeu
        $this->render("form_add", $data);  // Le formulaire d'ajout est affiché avec les données récupérées
    }
    
    public function action_add() {
        $ajout = false;
    
        // Test si les informations nécessaires sont fournies
        if (isset($_POST["titre_jeu"]) && !preg_match("/^ *$/", $_POST["titre_jeu"])) {
            $m = Model::getModel();
    
            // Vérification des autres champs, ceux qui ne sont pas required doivent être gérés comme null si vides
            $infos = [];
            $noms = [
                'identifiant',
                'titre_jeu', 
                'date_parution_debut', 
                'date_parution_fin', 
                'information_date', 
                'version', 
                'nombre_joueurs', 
                'age_min', 
                'mots_cles'
            ];
    
            foreach ($noms as $v) {
                // Vérifie si la valeur existe et si elle n'est pas vide
                $infos[$v] = isset($_POST[$v]) && !preg_match("/^ *$/", $_POST[$v]) ? $_POST[$v] : null;
            }
    
            // Ajout du jeu dans la base
            $jeu_id = $m->addJeu($infos);
            if ($jeu_id === false) {
                $data = [
                    "title" => "Ajouter un jeu",
                    "message" => "Il y a eu un problème lors de l'ajout du jeu."
                ];
                $this->render("message", $data);
                return;
            }
    
            // Ajout des associations avec les autres tables
            // Ajout des catégories
            if (isset($_POST["categorie"])) {
                foreach ($_POST["categorie"] as $categorie_id) {
                    $m->addJeuCategorie($jeu_id, $categorie_id);
                }
            }
    
            // Ajout des auteurs
            if (isset($_POST["auteur"])) {
                foreach ($_POST["auteur"] as $auteur_id) {
                    $m->addJeuAuteur($jeu_id, $auteur_id);
                }
            }
    
            // Ajout des éditeurs
            if (isset($_POST["editeur"])) {
                foreach ($_POST["editeur"] as $editeur_id) {
                    $m->addJeuEditeur($jeu_id, $editeur_id);
                }
            }
    
            // Ajout des mécanismes (ajouter un mécanisme à partir du texte)
            if (isset($_POST["mecanisme"]) && !empty($_POST["mecanisme"])) {
                $mecanismes = explode(",", $_POST["mecanisme"]); // On sépare par des virgules
                foreach ($mecanismes as $mecanisme) {
                    $mecanisme = trim($mecanisme); // Enlever les espaces avant et après
                    if (!empty($mecanisme)) {
                        // Vérification si le mécanisme existe déjà dans la base de données
                        $mecanisme_id = $m->getMecanismeIdByName($mecanisme);
                        if ($mecanisme_id === false) {
                            // Ajouter le mécanisme à la base s'il n'existe pas
                            $mecanisme_id = $m->addMecanisme($mecanisme);
                        }
                        // Associer ce mécanisme au jeu
                        $m->addJeuMecanisme($jeu_id, $mecanisme_id);
                    }
                }
            }
    
            // Si tout est bon, succès
            $ajout = true;
        }
    
        // Affichage du message
        $data = [
            "title" => "Ajouter un jeu",
            "message" => $ajout ? "Le jeu a été ajouté avec succès." : "Il y a eu un problème lors de l'ajout du jeu."
        ];
        $this->render("message", $data);
    }

    // ----------------------------- FIN ADD ----------------------------- //
    
    // ----------------------------- DEBUT UPDATE USER ----------------------------- //

    public function action_form_update_user()
    {
        // Vérification que l'ID est bien présent et valide
        if (isset($_GET['id']) && preg_match("/^[1-9]\d*$/", $_GET['id'])) {
            $id_utilisateur = $_GET['id'];

            // Récupération des informations de l'utilisateur à partir du modèle
            $m = Model::getModel();
            $utilisateur = $m->getUtilisateurParId($id_utilisateur);

            if ($utilisateur) {
                // Envoie des informations de l'utilisateur pour les préremplir dans le formulaire
                $data = [
                    'utilisateur_id' => $utilisateur['utilisateur_id'],
                    'nom' => $utilisateur['nom'],
                    'email' => $utilisateur['email'],
                    'role' => $utilisateur['role']
                ];

                // Affiche le formulaire de modification
                $this->render('form_update_user', $data);
            } else {
                // Si l'utilisateur n'existe pas, afficher un message d'erreur
                $this->action_error("L'utilisateur n'existe pas.");
            }
        } else {
            // ID non valide ou manquant
            $this->action_error("ID d'utilisateur invalide.");
        }
    }

    public function action_update_user()
    {
        if (isset($_POST['utilisateur_id']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['role'])) {
            $m = Model::getModel();

            // Préparation des données
            $id = $_POST['utilisateur_id'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            // Mise à jour des informations de l'utilisateur dans la base de données
            $m->updateUtilisateur($id, $nom, $email, $role);

            // Message de confirmation
            $data = [
                "title" => "Modifier l'utilisateur",
                "message" => "Les informations de l'utilisateur ont été mises à jour avec succès."
            ];
            $this->render("message", $data);
        } else {
            // Si des informations sont manquantes
            $this->action_error("Les informations envoyées sont incomplètes.");
        }
    }

    // ----------------------------- FIN UPDATE USER ----------------------------- //

    public function action_remove_user()
    {
        if (isset($_GET["id_user"]) and preg_match("/^[1-9]\d*$/", $_GET["id_user"])) {
            $id = $_GET["id_user"];

            $m = Model::getModel();
            $suppression = $m->removeUserParId($id);
            if ($suppression) {
                $message = "L'utilisateur a été supprimé.";
            } else {
                $message = "Il n'y a pas d'utilisateur avec l'identifiant :  " . $id . " !";
            }
        } else {
            $message = "There is no id in the URL!";
        }

        $data = [
            "title" => "Suppression d'utilisateur",
            "message" => $message,
        ];
        $this->render("message", $data);
    }
    
}
