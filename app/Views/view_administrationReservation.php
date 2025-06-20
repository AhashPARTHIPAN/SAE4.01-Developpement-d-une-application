<?php
require_once "view_begin.php" ?>

<h1>Gestion des réservations</h1>
<!-- Formulaire de recherche -->
<form method="get" style="margin-bottom: 1em;">
    <input type="hidden" name="controller" value="administration">
    <input type="hidden" name="action" value="administrationReservation">
    <input type="text" name="search" placeholder="Rechercher par jeu ou utilisateur" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Rechercher</button>
</form>
<button id="toggleRendues" style="margin-bottom:1em;">Masquer les réservations rendues</button>
<table id="tableResa">
    <tr>
        <th>Jeu</th>
        <th>Utilisateur</th>
        <th>Date d'emprunt</th>
        <th>Date de retour</th>
        <th>Action</th>
    </tr>
    <?php foreach ($prets as $pret): ?>
        <?php
        $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
        $jeu = strtolower($pret['nom_jeu']);
        $utilisateur = strtolower($pret['utilisateur']);
        if ($search && strpos($jeu, $search) === false && strpos($utilisateur, $search) === false) continue;
        $isRendu = !empty($pret['date_retour']);
        ?>
    <tr class="resa-row<?= $isRendu ? ' resa-rendue' : '' ?>">
        <td><?= htmlspecialchars($pret['nom_jeu']) ?></td>
        <td><?= htmlspecialchars($pret['utilisateur']) ?> (<?= htmlspecialchars($pret['utilisateur_id'] ?? '') ?>)</td>
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
