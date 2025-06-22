<?php
require_once "view_begin.php" ?>
<div class="container">
    <h1>Recherche Avancée</h1>
    <form class="recherche-avancee" action="index.php" method="GET">
        <input type="hidden" name="controller" value="recherche">
        <input type="hidden" name="action" value="rechercheAvancee">
        <div class="form-group">
            <label for="titre-jeu">Titre du jeu</label>
            <input type="text" id="titre" name="titre" placeholder="Rechercher par titre" value="" oninput="desactiverChamp()" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select id="categorie" name="categorie">
                <option value="">Toutes les catégories</option>
                
                <?php foreach($categorie as $cat):?>
                    <option value="<?= htmlspecialchars($cat['nom_categorie']) ?>"><?= htmlspecialchars($cat['nom_categorie'])?></option>
                <?php endforeach?>
            </select>
        </div>
        <div class="form-group">
            <label for="nb-joueurs">Nombre de joueurs</label>
            <select id="nbJoueur" name="nbJoueur">
                <option value="">Nombre de joueurs</option>
                <?php foreach ($nbJoueur as $nb): ?>
                    <option value="<?= htmlspecialchars($nb['nombre_de_joueurs']) ?>">
                        <?= htmlspecialchars($nb['nombre_de_joueurs']) ?></option>
                <?php endforeach?>
            </select>
        </div>
        <div class="form-group">
            <label for="dateSortie">Date de sortie</label>
            <select id="dateSortie" name="dateSortie">
            <option value="">Toutes les dates</option>
                <?php foreach ($date as $d): ?>
                    <option value="<?= htmlspecialchars($d['date_sortie']) ?>">
                        <?= htmlspecialchars($d['date_sortie']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="Bouton">Rechercher</button>
        </div>
    </form>
</div>

<script>
// Fonction pour activer ou désactiver les champs en fonction du titre
function desactiverChamp() {
    var titre = document.getElementById('titre').value;
    var categorie = document.getElementById('categorie');
    var nbJoueur = document.getElementById('nbJoueur');
    var dateSortie = document.getElementById('dateSortie');

    // Si un titre est rempli, on désactive les autres champs
    if (titre.trim() !== "") {
        categorie.disabled = true;
        nbJoueur.disabled = true;
        dateSortie.disabled = true;
    } else {
        // Si le titre est vide, on réactive les autres champs
        categorie.disabled = false;
        nbJoueur.disabled = false;
        dateSortie.disabled = false;
    }
}

// Appeler la fonction au chargement de la page pour gérer le cas où le titre est déjà renseigné
window.onload = desactiverChamp;
</script>

<?php require_once "view_end.php" ?>
