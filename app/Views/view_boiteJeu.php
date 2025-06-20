<?php
require_once "view_begin.php" ?>

<!-- Section principale -->
<div class="container">
    <?php if (!empty($message_resa)): ?>
        <div class="alert-success" style="color: green; font-weight: bold; margin-bottom: 1em;">
            <?= htmlspecialchars($message_resa) ?>
        </div>
    <?php endif; ?>
    <div>
        <div class="game-image">
            <!-- image potentiel -->
        </div>
    </div>

    <!-- Colonne des détails -->
    <div class="details-jeu">
        <h1 class="titre"><?= htmlspecialchars($jeu['titre']) ?></h1>
        <div class="boite-dispo">
            <h3>Boîtes disponibles : <?= htmlspecialchars($nb_exemplaires) ?></h3>
            <?php foreach ($boites as $boite): ?>
                <div class="boite">
                    <p>État : <?= htmlspecialchars($boite['etat']) ?></p>
                    <p>Localisation : Salle <?= htmlspecialchars($boite['salle']) ?></p>
                    <?php if ($boite['disponible'] ?? true): ?>
                        <form method="post" action="index.php?controller=list&action=reserverBoite">
                            <input type="hidden" name="id_boite" value="<?= htmlspecialchars($boite['id_boite']) ?>">
                            <button type="submit" class="reserve-button">Réserver</button>
                        </form>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold;">Déjà réservée</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Section des jeux similaires -->
<div class="jeux-similaires">
    <h2>Autres jeux similaires :</h2>
    <div class="cards">
        <?php foreach ($jeux_similaires as $jeu_similaire): ?>
            <a href="?controller=list&action=jeuPresentation&id_jeu=<?= htmlspecialchars($jeu_similaire['id']) ?>">
                <div class="card">
                    <h3><?= htmlspecialchars($jeu_similaire['nom']) ?></h3>
                    <p><?= htmlspecialchars($jeu_similaire['categorie']) ?></p>
                    <p><?= htmlspecialchars($jeu_similaire['nb_boites']) ?> exemplaire(s) disponible(s)</p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once "view_end.php"; ?>
