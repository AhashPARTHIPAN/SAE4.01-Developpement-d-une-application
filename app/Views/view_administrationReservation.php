<?php require_once "view_begin.php" ?>

<h1>Gestion des réservations</h1>
<table>
    <tr>
        <th>Jeu</th>
        <th>Utilisateur</th>
        <th>Date d'emprunt</th>
        <th>Date de retour</th>
        <th>Action</th>
    </tr>
    <?php foreach ($prets as $pret): ?>
    <tr>
        <td><?= htmlspecialchars($pret['nom_jeu']) ?></td>
        <td><?= htmlspecialchars($pret['utilisateur']) ?> (<?= htmlspecialchars($pret['utilisateur_id']) ?>)</td>
        <td><?= htmlspecialchars($pret['date_emprunt']) ?></td>
        <td><?= $pret['date_retour'] ? htmlspecialchars($pret['date_retour']) : 'En cours' ?></td>
        <?php if (!$pret['date_retour']): ?>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id_pret" value="<?= htmlspecialchars($pret['id_pret']) ?>">
                    <button type="submit" name="rendre" class="btn-rendre">Rendre</button>
                </form>
            </td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once "view_end.php" ?>
