<?php
require_once "view_begin.php" ?>

<h1 id="presentation">Liste des jeux - Page <?= $active ?></h1>

<?php require "view_liste_jeuPopulaire.php" ?>

<div class="listePages">
    <p> Pages: </p>
    <?php if ($active > 1) : ?>
        <a href="?controller=list&action=pagination&start=<?=$active - 1 ?>"> <img class="icone" src="Content/img/previous-icon.png" alt="Previous" /> </a>
    <?php endif ?>

    <?php for($p = $debut; $p <= $fin; $p++): ?>

        <a class="<?= $p == $active ? "lienStart active" : "lienStart" ?>" href="?controller=list&action=pagination&start=<?= $p ?>"> <?= $p ?> </a>
    <?php endfor ?> 

    <?php if ($active < $nb_total_pages) : ?>
        <a href="?controller=list&action=pagination&start=<?= $active + 1 ?>"> <img class="icone" src="Content/img/next-icon.png" alt="Next" /> </a>
    <?php endif ?>
</div>

<?php require_once "view_end.php"; ?>
