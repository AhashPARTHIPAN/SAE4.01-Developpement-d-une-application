<?php
require_once "view_begin.php" ?>

<section id="presentation">

    <?php if (isset($_SESSION['utilisateur'])): ?>
        <div>
            <h1 class="section-title">Bienvenue, <?= htmlspecialchars($_SESSION['utilisateur']['nom']) ?> !</h1>
        </div>
    <?php endif; ?>

    <div>
        <h1 class="section-title">Cherchez un jeu parmi nos <span class="highlight"><?= htmlspecialchars($nb_jeux) ?></span> jeux !</h1>
        
        <!-- Formulaire de recherche -->
        <form method="GET" action="index.php">
            <input type="search" name="mot_cle" placeholder="🔍 Rechercher un jeu par mot-clé..." required>
            <input type="hidden" name="controller" value="list">
            <input type="hidden" name="action" value="rechercheParMotCle">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <div>
        <h1 class="section-title">Collection de jeux de société</h1>
        <h4>Découvrez notre sélection complète</h4>
        <a href="?controller=list&action=pagination" class="btn-discover">🎲 Découvrir</a>
    </div>

    <div>
        <h1 class="section-title">Top 10 des jeux préférés de nos utilisateurs</h1>
        <table class="table-populaires">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Nombre d'emprunts</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jeux as $jeu): ?>
                    <tr>
                        <td>
                            <a href="?controller=list&action=jeuPresentation&id_jeu=<?= $jeu['id_jeu'] ?>">
                                <?= htmlspecialchars($jeu['titre']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($jeu['nombre_emprunts']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>

<?php require_once 'view_end.php'; ?>