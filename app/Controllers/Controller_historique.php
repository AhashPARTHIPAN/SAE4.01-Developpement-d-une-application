<?php
class Controller_historique extends Controller
{
    public function action_default()
    {
        $this->action_afficher();
    }

    public function action_afficher()
    {
        if (
            !isset($_SESSION['utilisateur']) ||
            ($_SESSION['utilisateur']['role'] !== 'Admin' && $_SESSION['utilisateur']['role'] !== 'Gestionnaire')
        ) {
            header('Location: index.php');
            exit;
        }

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $m = Model::getModel();
        $data = $m->getHistorique($page);

        $this->render('historique', $data);
    }
}
?>