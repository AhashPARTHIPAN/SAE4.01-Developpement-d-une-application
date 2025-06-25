<?php require_once "view_begin.php" ?>

<div class="container">
    <h1>Panneau d'administration</h1>
    <!-- Bouton d'accès gestion réservations, utilisateurs, historique, export -->
    <?php if ($_SESSION['utilisateur']['role'] === 'Admin' || $_SESSION['utilisateur']['role'] === 'Gestionnaire'): ?>
        <div class="admin-button">
            <a href="index.php?controller=administration&action=administrationReservation" class="Bouton">Gestion des réservations</a>
            <?php if ($_SESSION['utilisateur']['role'] === 'Admin'): ?>
                <a href="index.php?controller=administration&action=administrationUtilisateur" class="Bouton">Gestion des utilisateurs</a>
            <?php endif; ?>
            <a href="index.php?controller=historique" class="Bouton">Historique</a>
            <a href="index.php?controller=exportation&action=exportation" class="Bouton">Exporter les données</a>
        </div>
    <?php endif; ?>

    <?php if ($role === 'Admin' || $role === 'Gestionnaire'): ?>
        <!-- Gestion des jeux -->
        <div class="admin-section">
            <h2>Gestion des jeux</h2>
            <a href="?controller=set&action=form_add"><button class="Bouton">Ajouter un jeu</button></a>
            <a href="?controller=administration&action=paginationJeux" class="Bouton">Voir tous les jeux (paginé)</a>
            <!-- Barre de recherche -->
            <input type="text" id="recherche-jeu-admin" placeholder="Rechercher un jeu..." style="margin:10px 0; padding:5px; width:250px;">
            <table id="table-jeux-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jeux as $jeu): ?>
                        <tr>
                            <td><?= htmlspecialchars($jeu['id_jeu']) ?></td>
                            <td><?= htmlspecialchars($jeu['titre']) ?></td>
                            <td><?= htmlspecialchars($jeu['categories']) ?></td>
                            <td>
                                <a href="?controller=set&action=form_update&id_jeu=<?= $jeu["id_jeu"] ?>"><button class="Bouton">Modifier</button></a>
                                <!-- Bouton supprimer avec confirmation -->
                                <button class="Bouton Noir" onclick="confirmSuppression(<?= $jeu['id_jeu'] ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if (isset($nb_total_pages) && $nb_total_pages > 1): ?>
                <div class="listePages">
                    <p>Pages :</p>
                    <?php if ($active > 1): ?>
                        <a href="?controller=administration&action=administration&start=<?= $active - 1 ?>">
                            <img class="icone" src="Content/img/previous-icon.png" alt="Previous" />
                        </a>
                    <?php endif; ?>

                    <?php for($p = $debut; $p <= $fin; $p++): ?>
                        <a class="<?= $p == $active ? "active" : "" ?>" 
                           href="?controller=administration&action=administration&start=<?= $p ?>">
                            <?= $p ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($active < $nb_total_pages): ?>
                        <a href="?controller=administration&action=administration&start=<?= $active + 1 ?>">
                            <img class="icone" src="Content/img/next-icon.png" alt="Next" />
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Script JavaScript pour confirmation et recherche -->
    <script>
        function confirmSuppression(idJeu) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce jeu ?")) {
                window.location.href = "?controller=set&action=remove&id_jeu=" + idJeu;
            }
        }
        // Filtre de recherche pour la table des jeux
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('recherche-jeu-admin');
            const rows = document.querySelectorAll('#table-jeux-admin tbody tr');
            input.addEventListener('input', function() {
                const filtre = input.value.toLowerCase();
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(filtre) ? '' : 'none';
                });
            });
        });
    </script>

<?php require_once "view_end.php" ?>
=======
<?php
require_once "view_begin.php" ?>

<div class="container">
    <h1>Panneau d'administration</h1>
    <!-- Bouton d'accès gestion réservations -->
    <?php if ($_SESSION['utilisateur']['role'] === 'Admin' || $_SESSION['utilisateur']['role'] === 'Gestionnaire'): ?>
        <div class="admin-button">
            <a href="index.php?controller=administration&action=administrationReservation" class="Bouton">Gestion des réservations</a>
            <?php if ($_SESSION['utilisateur']['role'] === 'Admin'): ?>
                <a href="index.php?controller=administration&action=administrationUtilisateur" class="Bouton">Gestion des utilisateurs</a>
            <?php endif; ?>
            <a href="index.php?controller=historique" class="Bouton">Historique</a>
            <a href="index.php?controller=exportation&action=exportation" class="Bouton">Exporter les données</a>
        </div>
    <?php endif; ?>

    <?php if ($role === 'Admin' || $role === 'Gestionnaire'): ?>
        <!-- Gestion des jeux -->
        <div class="admin-section">
            <h2>Gestion des jeux</h2>
            <a href="?controller=set&action=form_add"><button class="Bouton">Ajouter un jeu</button></a>
            <!-- Barre de recherche -->
            <input type="text" id="recherche-jeu-admin" placeholder="Rechercher un jeu..." style="margin:10px 0; padding:5px; width:250px;">
            <h1 id="presentation">Liste des jeux - Page <?= $active ?></h1>
            <table id="table-jeux-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($liste as $jeu): ?>
                        <tr>
                            <td><?= htmlspecialchars($jeu['id_jeu']) ?></td>
                            <td><?= htmlspecialchars($jeu['titre']) ?></td>
                            <td><?= htmlspecialchars($jeu['categories']) ?></td>
                            <td>
                                <a href="?controller=set&action=form_update&id_jeu=<?= $jeu["id_jeu"] ?>"><button class="Bouton">Modifier</button></a>
                                <button class="Bouton Noir" onclick="confirmSuppression(<?= $jeu['id_jeu'] ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="listePages">
            <p> Pages: </p>
            <?php if ($active > 1) : ?>
                <a href="?controller=administration&action=administration&start=<?=$active - 1 ?>"> <img class="icone" src="Content/img/previous-icon.png" alt="Previous" /> </a>
            <?php endif ?>

            <?php for($p = $debut; $p <= $fin; $p++): ?>
                <a class="<?= $p == $active ? "lienStart active" : "lienStart" ?>" href="?controller=administration&action=administration&start=<?= $p ?>"> <?= $p ?> </a>
            <?php endfor ?> 

            <?php if ($active < $nb_total_pages) : ?>
                <a href="?controller=administration&action=administration&start=<?= $active + 1 ?>"> <img class="icone" src="Content/img/next-icon.png" alt="Next" /> </a>
            <?php endif ?>
        </div>
    <?php endif; ?>

    <!-- Script JavaScript pour confirmation -->
    <script>
        function confirmSuppression(idJeu) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce jeu ?")) {
                window.location.href = "?controller=set&action=remove&id_jeu=" + idJeu;
            }
        }
        // Filtre de recherche plus court pour la table des jeux
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('recherche-jeu-admin');
            const rows = document.querySelectorAll('#table-jeux-admin tbody tr');
            input.addEventListener('input', function() {
                const filtre = input.value.toLowerCase();
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(filtre) ? '' : 'none';
                });
            });
        });
    </script>
<?php require_once "view_end.php" ?>
>>>>>>> develop
