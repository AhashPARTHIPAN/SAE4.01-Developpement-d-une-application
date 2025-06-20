<?php
require_once "view_begin.php" ?>
<br>
<h1>Voici la liste des jeux correspondant <?php if(isset($_GET['mot_cle'])){echo ('pour ' .'"'.$_GET['mot_cle'].'"');}?> :</h1>
<br>
<table class="table_rendu">
        <thead>
            <tr>
                <th>Titre</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (count($lesTitres) <= 0){echo " <tr><td>aucun titre ne correspond à la recherche </td></tr>";}?>
            <?php foreach ($lesTitres as $jeu): ?>
                <tr>
                    <td><a href="?controller=list&action=jeuPresentation&id_jeu=<?= $jeu['id_jeu'] ?>"><?= htmlspecialchars($jeu['titre']) ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php require_once "view_end.php" ?>
