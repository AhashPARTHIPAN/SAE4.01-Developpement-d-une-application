<?php require_once "view_begin.php" ?>

<div class="container">
    <h1>Gestion des réservations</h1>

    <!-- Formulaire de recherche -->
    <form method="get" style="margin-bottom: 1em;">
        <input type="hidden" name="controller" value="administration">
        <input type="hidden" name="action" value="administrationReservation">
        <input type="text" name="search" placeholder="Rechercher par jeu ou utilisateur" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="Bouton">Rechercher</button>
    </form>
    <button id="toggleRendues" style="margin-bottom:1em;" class="Bouton">Masquer les réservations rendues</button>

    <?php if ($role === 'Admin' || $role === 'Gestionnaire'): ?>
        <div class="admin-section">
            <h2>Liste des réservations</h2>
            <a href="?controller=administration&action=paginationReservations" class="Bouton">Voir toutes les réservations (paginé)</a>
            <table id="tableResa">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du jeu</th>
                        <th>Utilisateur</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($prets as $pret): ?>
                    <?php
                        $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
                        $jeu = strtolower($pret['nom_jeu']);
                        $utilisateur = strtolower($pret['utilisateur']);
                        if ($search && strpos($jeu, $search) === false && strpos($utilisateur, $search) === false) continue;
                        $isRendu = !empty($pret['date_retour']);
                    ?>
                    <tr class="resa-row<?= $isRendu ? ' resa-rendue' : '' ?>">
                        <td><?= htmlspecialchars($pret['id_reservation']) ?></td>
                        <td><?= htmlspecialchars($pret['nom_jeu']) ?></td>
                        <td><?= htmlspecialchars($pret['utilisateur']) ?></td>
                        <td><?= htmlspecialchars($pret['date_emprunt']) ?></td>
                        <td><?= $pret['date_retour'] ? htmlspecialchars($pret['date_retour']) : 'En cours' ?></td>
                        <td><?= htmlspecialchars($pret['statut']) ?></td>
                        <td>
                            <?php if (!$pret['date_retour']): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($pret['id_reservation']) ?>">
                                    <button type="submit" name="rendre" class="btn-rendre Bouton">Rendre</button>
                                </form>
                            <?php endif; ?>
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
                        <a href="?controller=administration&action=administrationReservation&start=<?= $active - 1 ?>">
                            <img class="icone" src="Content/img/previous-icon.png" alt="Previous" />
                        </a>
                    <?php endif; ?>

                    <?php for($p = $debut; $p <= $fin; $p++): ?>
                        <a class="<?= $p == $active ? "active" : "" ?>" 
                            href="?controller=administration&action=administrationReservation&start=<?= $p ?>">
                            <?= $p ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($active < $nb_total_pages): ?>
                        <a href="?controller=administration&action=administrationReservation&start=<?= $active + 1 ?>">
                            <img class="icone" src="Content/img/next-icon.png" alt="Next" />
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
const btn = document.getElementById('toggleRendues');
let renduesCachees = false;
btn.addEventListener('click', function() {
    const rows = document.querySelectorAll('.resa-rendue');
    renduesCachees = !renduesCachees;
    rows.forEach(row => {
        row.style.display = renduesCachees ? 'none' : '';
    });
    btn.textContent = renduesCachees ? 'Afficher les réservations rendues' : 'Masquer les réservations rendues';
});
</script>

<?php require_once "view_end.php" ?>
