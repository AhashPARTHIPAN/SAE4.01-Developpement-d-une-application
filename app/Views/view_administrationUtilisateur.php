<?php require_once "view_begin.php" ?>

<div class="container">
    <h1>Gestion des utilisateurs</h1>
    
    <?php if ($role === 'Admin'): ?>
        <!-- Gestion des utilisateurs -->
        <div class="admin-section">
            <h2>Gestion des utilisateurs</h2>
            <a href="?controller=administration&action=paginationUtilisateurs" class="Bouton">Voir tous les utilisateurs (paginé)</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $utilisateur): ?>
                        <tr>
                            <td><?= htmlspecialchars($utilisateur['utilisateur_id']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                            <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                            <td>
                                <!-- Lien vers l'action form_update_user avec l'ID de l'utilisateur -->
                                <a href="index.php?controller=set&action=form_update_user&id=<?= $utilisateur['utilisateur_id'] ?>" class="Bouton">Modifier</a>
                                <!-- <a href="index.php?controller=set&action=supprimer&id=<?= $utilisateur['utilisateur_id'] ?>" class="Bouton">Supprimer</a> -->
                                <button class="Bouton Noir" onclick="confirmSuppression(<?= $utilisateur['utilisateur_id'] ?>)">Supprimer</button>
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
                        <a href="?controller=administration&action=administrationUtilisateur&start=<?= $active - 1 ?>">
                            <img class="icone" src="Content/img/previous-icon.png" alt="Previous" />
                        </a>
                    <?php endif; ?>

                    <?php for($p = $debut; $p <= $fin; $p++): ?>
                        <a class="<?= $p == $active ? "active" : "" ?>" 
                           href="?controller=administration&action=administrationUtilisateur&start=<?= $p ?>">
                            <?= $p ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($active < $nb_total_pages): ?>
                        <a href="?controller=administration&action=administrationUtilisateur&start=<?= $active + 1 ?>">
                            <img class="icone" src="Content/img/next-icon.png" alt="Next" />
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmSuppression(idUser) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            // Rediriger vers la suppression si l'utilisateur confirme
            window.location.href = "?controller=set&action=remove_user&id_user=" + idUser;
        }
    }
</script>

<?php require_once "view_end.php" ?>
