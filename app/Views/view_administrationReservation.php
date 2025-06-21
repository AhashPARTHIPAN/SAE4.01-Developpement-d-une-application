<?php require_once "view_begin.php" ?>

<div class="container">
    <h1>Gestion des réservations</h1>

<?php if ($role === 'Admin' || $role === 'Gestionnaire'): ?>
            <!-- Gestion des réservations -->
            <div class="admin-section">
                <h2>Gestion des réservations</h2>
            <a href="?controller=administration&action=paginationReservations" class="Bouton">Voir toutes les réservations (paginé)</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du jeu</th>
                            <th>Utilisateur</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?= htmlspecialchars($reservation['id_reservation']) ?></td>
                                <td><?= htmlspecialchars($reservation['nom_jeu']) ?></td>
                                <td><?= htmlspecialchars($reservation['utilisateur']) ?></td>
                                <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
                                <td><?= htmlspecialchars($reservation['statut']) ?></td>
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

<?php require_once "view_end.php" ?>
