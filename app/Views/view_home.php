<?php
require_once "view_begin.php" ?>

<section id="presentation">
    <?php if (isset($_SESSION['utilisateur'])): ?>
        <div>
            <h1>Bienvenue, <?= htmlspecialchars($_SESSION['utilisateur']['nom']) ?>!</h1>
        </div>
    <?php endif; ?>

    <div>
        <h1>Chercher un jeu parmi nos <?= htmlspecialchars($nb_jeux) ?> jeux !</h1>
        <!-- Recherche par mots clés -->
        <form method="GET" action="index.php">
            <input type="search" name="mot_cle" placeholder="Rechercher un jeu par mot-clé" required>
            <input type="hidden" name="controller" value="list">
            <input type="hidden" name="action" value="rechercheParMotCle">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <div id="presentation">
        <h1>Collection de jeux de sociétés</h1>
        <h4>Découvrez notre collection de jeux de sociétés</h4>
        <a href="?controller=list&action=pagination"><input type='button' class="Bouton" value="Découvrir"/></a>
    </div>

    <h1>Nos 10 jeux les plus populaires chez nos utilisateurs !</h1>
    <table class="table_rendu">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Nombre d'emprunts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jeux as $jeu): ?>
                <tr>
                    <td><a href="?controller=list&action=jeuPresentation&id_jeu=<?= $jeu['id_jeu'] ?>"><?= htmlspecialchars($jeu['titre']) ?></a></td>
                    <td><?= htmlspecialchars($jeu['nombre_emprunts']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once 'view_end.php'; ?>
