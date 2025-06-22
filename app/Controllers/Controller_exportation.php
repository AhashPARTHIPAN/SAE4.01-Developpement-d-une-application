<?php

class Controller_exportation extends Controller
{
    public function action_default()
    {
        $this->action_exportation();
    }

    public function action_exportation(){

        require_once "identifiants/identifiant.php";

        if (!isset($_SESSION['utilisateur']['role']) || $_SESSION['utilisateur']['role'] != "Admin") {
            $this->action_error("Vous n'êtes pas autorisé à accéder à cette page.");
        }

        $path_to_script = realpath("scripts/scripts_exportation/script_exportation.py");

        $cmd = "python " . escapeshellarg($path_to_script) . " "
            . escapeshellarg($host) . " "
            . escapeshellarg($username) . " "
            . escapeshellarg($password) . " "
            . escapeshellarg($database);

        exec($cmd, $output, $return_var);

        $fichier_genere = "scripts/data/export_jeux.xlsx";

        if (file_exists($fichier_genere)) {
            // Envoie les bons en-têtes pour le téléchargement
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="export_jeux.xlsx"');
            header('Content-Length: ' . filesize($fichier_genere));
            readfile($fichier_genere);
            exit;
        } else {
            $this->action_error("Le fichier n'a pas été généré.");
        }
    }
}
