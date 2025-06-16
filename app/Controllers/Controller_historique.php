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
        $m = Model::getModel();
        $data = [
            'logs' => $m->getHistorique()
        ];
        $this->render('historique', $data);
    }
}
?>