<?php

class Controller_list extends Controller
{
    public function action_last()
    {
        $m = Model::getModel();
        $data = [
            "jeux" => $m->getLast25(),
        ];
        $this->render("home", $data);
    }

    public function action_default()
    {
        $this->action_last();
    }

    public function action_jeuPresentation() {
        $data = false;

        if (isset($_GET["id_jeu"]) and preg_match("/^[1-9]\d*$/", $_GET["id_jeu"])) {
            $m = Model::getModel();
            $data = [ "unJeux" => $m->getJeuParId($_GET["id_jeu"]),
            "nb_boite" => $m->getNbBoite($_GET["id_jeu"]),
            "jeuSim" => $m->getJeuSimilaire($_GET["id_jeu"]),
        ];
        }
        
        //Si on a bien un jeu d'identifiant$_GET["id"]
        if ($data !== false) {
            $this->render("jeuPresentation", $data);
        } else {
            $this->action_error("Pas de jeu avec cet id !");
        }
    }

public function action_rechercheParMotCle() {
    $m = Model::getModel();
    $data = [
        "categorie" => $m->getCategories(),
        "date" => $m->getDateDeSortie(),
        "nbJoueur" => $m->getNbJoueurs(),
    ];
    if (isset($_GET["mot_cle"])) {
        $resultats = $m->getParMotCle($_GET["mot_cle"]);
        if (!empty($resultats)) {
            $data["lesTitres"] = $resultats;
            // Afficher les résultats dans la vue home.php
            $this->render("resultatRecherche", $data);
        } else {
            $this->action_error("Aucun jeu trouvé avec ce mot-clé !");
        }
    } else {
        $this->render("home", $data);
    }
}
    public function action_boiteJeu() {
        $model = Model::getModel();
        if (isset($_GET["id_jeu"]) and preg_match("/^[1-9]\d*$/", $_GET["id_jeu"])) {
            // Message de réservation depuis la session
            $message_resa = null;
            if (isset($_SESSION['message_resa'])) {
                $message_resa = $_SESSION['message_resa'];
                unset($_SESSION['message_resa']);
            }
            $boitesDisponibles = $model->getBoitesDisponibles($_GET["id_jeu"]);
            if ($boitesDisponibles === false || empty($boitesDisponibles)) {
                $this->action_error("Aucune boîte disponible pour ce jeu.");
                return;
            }
            $jeuInfo = $model->getJeuParId($_GET["id_jeu"]);
            if ($jeuInfo === false) {
                $this->action_error("Aucun jeu trouvé avec cet identifiant.");
                return;
            }
            $jeuxSimilaires = $model->getJeuSimilaire($_GET["id_jeu"]);
            $data = [
                'jeu' => $jeuInfo,
                'boites' => $boitesDisponibles,
                'nb_exemplaires' => count($boitesDisponibles),
                'jeux_similaires' => $jeuxSimilaires,
                'message_resa' => $message_resa
            ];
            $this->render("boiteJeu", $data);
        } else {
            $this->action_error("Identifiant de jeu invalide.");
        }
    }

    public function action_pagination()
    {
        $start = 1;
        if (isset($_GET["start"]) and preg_match("/^\d+$/", $_GET["start"]) and $_GET["start"] > 0) {
            $start = $_GET["start"];
        }

        $m = Model::getModel();

        //Récupération du nombre total de jeux
        $nb_jeux = $m->getNbJeux();

        $nb_total_pages = ceil($nb_jeux / 25);
        if ($nb_total_pages < $start) {
            $this->action_error("The page does not exist!");
        }

        //Détermination du premier résultat à récupérer dans la base de données
        $offset = ($start - 1) * 25;

        //Détermination du début et de la fin des numéros de page à afficher
        $debut = $start - 5;
        if($debut <= 0 ){
            $debut = 1;
        }
        
        $fin = $debut + 9;
        if($fin > $nb_total_pages){
            $fin = $nb_total_pages;
        }
        
        $data = [
            //Nb de pages
            'nb_total_pages' => $nb_total_pages,

            //indice de la page de résultats visualisée
            'active' => $start,

            //Récupération des jeux de la page $start
            'liste' => $m->getJeuxWithLimit($offset, 25),

            //Début et fin des urls des pages
            'debut' => $debut,

            'fin' => $fin
        ];

        //Affichage de la vue
        $this->render("pagination", $data);
    }
     public function action_reserverBoite() {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?controller=connexion_inscription&action=afficher&erreur=Veuillez vous connecter.');
            exit;
        }
        if (!isset($_POST['id_boite'])) {
            $this->action_error("Aucune boîte sélectionnée.");
            return;
        }
        $id_utilisateur = $_SESSION['utilisateur']['id'];
        $id_boite = $_POST['id_boite'];
        $model = Model::getModel();
        $ok = $model->reserverBoite($id_utilisateur, $id_boite);
        $jeu_id = $model->getJeuIdByBoite($id_boite);
        // Stocker le message en session pour affichage après redirection
        if ($ok) {
            $_SESSION['message_resa'] = "Réservation réussie !";
        } else {
            $_SESSION['message_resa'] = "Erreur : ce jeu est déjà réservé ou la boîte n'est plus disponible.";
        }
        // Rediriger vers la page du jeu (PRG pattern)
        header('Location: index.php?controller=list&action=boiteJeu&id_jeu=' . $jeu_id);
        exit;
    }

    public function action_suiviPrets() {
        if (!isset($_SESSION['utilisateur']) || ($_SESSION['utilisateur']['role'] != 'Gestionnaire' && $_SESSION['utilisateur']['role'] != 'Admin')) {
            header('Location: index.php');
            exit;
        }
        $model = Model::getModel();
        // Traitement du retour de boîte
        if (isset($_POST['rendre']) && isset($_POST['id_pret'])) {
            $model->rendrePret($_POST['id_pret']);
        }
        $prets = $model->getReservations();
        $this->render("suivi_prets", ["prets" => $prets]);
    }

   
}

?>
