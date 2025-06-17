<?php require_once "view_begin.php" ?>

    <h1> Ajouter un nouveau jeu </h1>

    <div id="container">
        <form class="form_add" action="?controller=set&action=add" method="post">
            <!-- Identifiant (champ pour l'utilisateur) -->
            <p><label> Identifiant : <input type="number" name="identifiant" required /> </label></p>

            <!-- Titre du jeu -->
            <p><label> Titre : <input type="text" name="titre_jeu" required /> </label></p>

            <!-- Date de parution (début et fin) -->
            <p><label> Date de parution début : <input type="number" name="date_parution_debut" required /> </label></p>
            <p><label> Date de parution fin : <input type="number" name="date_parution_fin" /> </label></p>

            <!-- Information supplémentaire sur la date -->
            <p><label> Information date : <input type="text" name="information_date" /> </label></p>

            <!-- Version du jeu -->
            <p><label> Version : <input type="text" name="version" required /> </label></p>

            <!-- Nombre de joueurs -->
            <p><label> Nombre de joueurs : <input type="text" name="nombre_joueurs" required /> </label></p>

            <!-- Âge minimum -->
            <p><label> Âge minimum : <input type="text" name="age_min" required /> </label></p>

            <!-- Mots clés -->
            <p><label> Mots clés : <textarea name="mots_cles" cols="70" rows="5"></textarea></label></p>

            <div class="form-group">
            <label for="categorie">Localisation</label>
            <select id="salle" name="salle">
                <option value="">Selectionner la salle</option>
                
                <?php foreach($localisationSalle as $locSalle):?>
                    <option value="<?= htmlspecialchars($locSalle['salle']) ?>"><?= htmlspecialchars($locSalle['salle'])?></option>
                <?php endforeach?>
            </select>
            
            <select id="etagere" name="etagere">
                <option value="">Selectionner l'étagère</option>
                
                <?php foreach($localisationEtagere as $locEtagere):?>
                    <option value="<?= htmlspecialchars($locEtagere['etagere']) ?>"><?= htmlspecialchars($locEtagere['etagere'])?></option>
                <?php endforeach?>
            </select>
            </div>

            <!-- Mécanisme -->
            <p><label> Mécanisme (vous pouvez en saisir plusieurs, séparés par des virgules) : 
                <input type="text" name="mecanisme" placeholder="Ex : Mécanisme 1, Mécanisme 2" />
            </label></p>

            <!-- Bouton pour soumettre le formulaire -->
            <p><button type="submit">Ajouter le jeu</button></p>
        </form>

    </div>

<?php require "view_end.php"; ?>
