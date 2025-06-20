<?php require_once "view_begin.php" ?>

<h1> Modification du jeu </h1>

<div id="container">
    <form class="form_update" action="?controller=set&action=update" method="post">
        <!-- ID caché pour identifier quel jeu est modifié -->
        <p><input type="hidden" name="id_jeu" value="<?= $id_jeu ?>" /></p>

        <!-- Titre du jeu -->
        <p><label> Titre : <input type="text" name="titre_jeu" value="<?= $titre ?>" /> </label></p>

        <!-- Date de parution (début et fin) -->
        <p><label> Date de parution début : <input type="number" name="date_parution_debut" value="<?= $date_parution_debut ?>" /> </label></p>
        <p><label> Date de parution fin : <input type="number" name="date_parution_fin" value="<?= $date_parution_fin ?>" /> </label></p>

        <!-- Information supplémentaire sur la date -->
        <p><label> Information date : <input type="text" name="information_date" value="<?= $information_date ?>" /> </label></p>

        <!-- Version du jeu -->
        <p><label> Version : <input type="text" name="version" value="<?= $version ?>" /> </label></p>

        <!-- Nombre de joueurs -->
        <p><label> Nombre de joueurs : <input type="text" name="nombre_joueurs" value="<?= $nombre_de_joueurs ?>" /> </label></p>

        <!-- Âge minimum -->
        <p><label> Âge minimum : <input type="text" name="age_min" value="<?= $age_indique ?>" /> </label></p>

        <!-- Mots clés -->
        <p><label> Mots clés : <textarea name="mots_cles" cols="70" rows="5"><?= $mots_cles ?></textarea></label></p>

        <!-- Bouton pour soumettre le formulaire -->
        <p><button type="submit">Mettre à jour le jeu</button></p>
    </form>
</div>

<?php require "view_end.php"; ?>
