<?php
require_once "view_begin.php" ?>
<table class="table_rendu">
    <tr> <th>Titre</th> <th>Mots clés</th> <th>Date de parution</th></tr>
    <?php foreach ($liste as $jeu): ?>
        <tr>
            <td><a href="?controller=list&action=jeuPresentation&id_jeu=<?= $jeu['id_jeu'] ?>"><?= htmlspecialchars($jeu['titre']) ?></a></td>
            <td><?= htmlspecialchars($jeu['mots_cles']) ?></td>
            <td><?= htmlspecialchars($jeu['date_parution_debut']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
