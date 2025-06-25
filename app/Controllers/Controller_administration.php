<?php 

class Controller_administration extends Controller {

    public function action_default()
    {
        $this->action_administration();
    }
    
    public function action_administration() {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?controller=connexion_inscription&action=afficher&erreur=Veuillez vous connecter.');
            exit;
        }
        $role = $_SESSION['utilisateur']['role'];
        if ($role !== 'Admin' && $role !== 'Gestionnaire') {
            header('Location: index.php');
            exit;
        }

        $model = Model::getModel();

        $start = 1;
        if (isset($_GET["start"]) and preg_match("/^\d+$/", $_GET["start"]) and $_GET["start"] > 0) {
            $start = $_GET["start"];
        }

        $nb_jeux = $model->getNbJeux();

        $nb_total_pages = ceil($nb_jeux / 25);
        if ($nb_total_pages < $start) {
            $this->action_error("The page does not exist!");
        }

        $offset = ($start - 1) * 25;

        $debut = $start - 5;
        if($debut <= 0 ){
            $debut = 1;
        }
        
        $fin = $debut + 9;
        if($fin > $nb_total_pages){
            $fin = $nb_total_pages;
        }

        if ($role === 'Admin') {
            $data = [
                'jeux' => $model->getJeux(),
                'utilisateurs' => $model->getUtilisateurs(),
                'reservations' => $model->getReservations(),
                'role' => $role,
                'nb_total_pages' => $nb_total_pages,
                'active' => $start,
                'liste' => $model->getJeuxWithLimit($offset, 25),
                'debut' => $debut,
                'fin' => $fin
            ];
        } elseif ($role === 'Gestionnaire') {
            $data = [
                'jeux' => $model->getJeux(),
                'reservations' => $model->getReservations(),
                'role' => $role,
                'nb_total_pages' => $nb_total_pages,
                'active' => $start,
                'liste' => $model->getJeuxWithLimit($offset, 25),
                'debut' => $debut,
                'fin' => $fin
            ];
        }

        $this->render("administration", $data);
    }   

    public function action_administrationUtilisateur() {
        // Vérification du rôle
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?controller=connexion_inscription&action=afficher&erreur=Veuillez vous connecter.');
            exit;
        }
        $role = $_SESSION['utilisateur']['role'];
        if ($role !== 'Admin' && $role !== 'Gestionnaire') {
            header('Location: index.php');
            exit;
        }

        $model = Model::getModel();
        // Récupération des données et render
        if ($role === 'Admin') {
            $data = [
                'jeux' => $model->getJeux(),
                'utilisateurs' => $model->getUtilisateurs(),
                'reservations' => $model->getReservations(),
                'role' => $role
            ];
        }
        $this->render("administrationUtilisateur", $data);

    }

    public function action_administrationReservation() {
        // Vérification du rôle
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: index.php?controller=connexion_inscription&action=afficher&erreur=Veuillez vous connecter.');
            exit;
        }
        $role = $_SESSION['utilisateur']['role'];
        if ($role !== 'Admin' && $role !== 'Gestionnaire') {
            header('Location: index.php');
            exit;
        }

        $model = Model::getModel();

        // Traitement du retour de prêt
        if (isset($_POST['rendre']) && !empty($_POST['id_pret'])) {
            $model->rendrePret($_POST['id_pret']);
            // Redirection pour éviter le repost du formulaire
            header('Location: index.php?controller=administration&action=administrationReservation');
            exit;
        }

        // Récupération des données et render
        if ($role === 'Gestionnaire' || $role === 'Admin' ) {
            $data = [
                'jeux' => $model->getJeux(),
                'prets' => $model->getReservations(),
                'role' => $role
            ];
        }

        $this->render("administrationReservation", $data);
    }
}
