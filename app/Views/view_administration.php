<?php require_once "view_begin.php" ?>


<div class="container">
        
        <h1>Panneau d'administration</h1>
        <!-- Bouton d'accès gestion réservations -->
        <?php if ($_SESSION['utilisateur']['role'] === 'Admin' || $_SESSION['utilisateur']['role'] === 'Gestionnaire'): ?>
	    <div class="admin-button">
		<a href="index.php?controller=administration&action=administrationReservation" class="Bouton">Gestion des réservations</a>
        <!-- Bouton d'accès gestion utilisateurs -->
        <?php if ($_SESSION['utilisateur']['role'] === 'Admin'): ?>
		<a href="index.php?controller=administration&action=administrationUtilisateur" class="Bouton">Gestion des utilisateurs</a>
        </div>
        <?php endif; ?>

        <?php endif; ?>
        
        <?php if ($role === 'Admin' || $role === 'Gestionnaire'): ?>
            <!-- Gestion des jeux -->
            <div class="admin-section">
                <h2>Gestion des jeux</h2>
                <a href="?controller=set&action=form_add"><button class="Bouton">Ajouter un jeu</button></a>
                <table>
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
                                    <a href="?controller=set&action=form_update&id_jeu=<?php echo $jeu["id_jeu"]?>"><button class="Bouton">Modifier</button></a>
                                    
                                    <!-- Bouton supprimer avec confirmation -->
                                    <button class="Bouton Noir" onclick="confirmSuppression(<?= $jeu['id_jeu'] ?>)">Supprimer</button>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Script JavaScript pour confirmation -->
        <script>
            function confirmSuppression(idJeu) {
                if (confirm("Êtes-vous sûr de vouloir supprimer ce jeu ?")) {
                    // Rediriger vers la suppression si l'utilisateur confirme
                    window.location.href = "?controller=set&action=remove&id_jeu=" + idJeu;
                }
            }
        </script>

<?php require_once "view_end.php" ?>
