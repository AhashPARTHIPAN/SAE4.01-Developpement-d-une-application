<?php require_once "view_begin.php" ?>

<link rel="stylesheet" href="Content/css/historique.css">

<div class="container">
    <h1>Historique des actions</h1>
    <div class="historique-container">
        <div class="historique-info">
            <p>Total des actions : <?= $total ?> entrées</p>
        </div>
        <table class="historique-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td class="date-cell"><?= htmlspecialchars($log['date_action']) ?></td>
                        <td class="user-cell"><?= htmlspecialchars($log['nom']) ?></td>
                        <td class="action-cell">
                            <?php
                            $actionClass = '';
                            if (strpos($log['action'], 'modification') !== false) {
                                $actionClass = 'action-modification';
                            } elseif (strpos($log['action'], 'suppression') !== false) {
                                $actionClass = 'action-suppression';
                            } elseif (strpos($log['action'], 'ajout') !== false) {
                                $actionClass = 'action-ajout';
                            }
                            ?>
                            <span class="action-badge <?= $actionClass ?>">
                                <?= htmlspecialchars($log['action']) ?>
                            </span>
                        </td>
                        <td class="details-cell">
                            <?php
                            // Essayer de décoder comme JSON d'abord
                            $detailsData = json_decode($log['details'], true);

                            if ($detailsData !== null) {
                                // Format JSON
                                if (isset($detailsData['id'])) {
                                    echo '<div class="detail-item">';
                                    echo '<span class="detail-key">ID:</span> ' . htmlspecialchars($detailsData['id']);
                                    echo '</div>';
                                }

                                if (isset($detailsData['titre'])) {
                                    echo '<div class="detail-item">';
                                    echo '<span class="detail-key">Titre:</span> ' . htmlspecialchars($detailsData['titre']);
                                    echo '</div>';
                                }

                                if (isset($detailsData['utilisateur'])) {
                                    $util = $detailsData['utilisateur'];
                                    if (isset($util['nom'])) {
                                        echo '<div class="detail-item">';
                                        echo '<span class="detail-key">Nom:</span> ' . htmlspecialchars($util['nom']);
                                        echo '</div>';
                                    }
                                    if (isset($util['email'])) {
                                        echo '<div class="detail-item">';
                                        echo '<span class="detail-key">Email:</span> ' . htmlspecialchars($util['email']);
                                        echo '</div>';
                                    }
                                    if (isset($util['role'])) {
                                        echo '<div class="detail-item">';
                                        echo '<span class="detail-key">Rôle:</span> ' . htmlspecialchars($util['role']);
                                        echo '</div>';
                                    }
                                }

                                if (isset($detailsData['jeu'])) {
                                    $jeu = $detailsData['jeu'];
                                    if (isset($jeu['titre'])) {
                                        echo '<div class="detail-item">';
                                        echo '<span class="detail-key">Titre:</span> ' . htmlspecialchars($jeu['titre']);
                                        echo '</div>';
                                    }
                                }

                                if (isset($detailsData['changes']) && is_array($detailsData['changes'])) {
                                    foreach ($detailsData['changes'] as $change) {
                                        if (isset($change['field']) && isset($change['old']) && isset($change['new'])) {
                                            echo '<div class="detail-item">';
                                            echo '<span class="detail-key">' . htmlspecialchars($change['field']) . ':</span> ';
                                            echo '<span class="old-value">' . htmlspecialchars($change['old']) . '</span>';
                                            echo '<span class="arrow">→</span>';
                                            echo '<span class="new-value">' . htmlspecialchars($change['new']) . '</span>';
                                            echo '</div>';
                                        }
                                    }
                                }
                            } else {
                                // Ancien format avec points-virgules (pour la compatibilité)
                                $details = explode(';', $log['details']);
                                foreach ($details as $detail) {
                                    $parts = explode('=', trim($detail));
                                    if (count($parts) === 2) {
                                        $key = trim($parts[0]);
                                        $value = trim($parts[1]);
                                        echo '<div class="detail-item">';
                                        echo '<span class="detail-key">' . htmlspecialchars($key) . ':</span> ';
                                        if (strpos($value, '->') !== false) {
                                            list($old, $new) = explode('->', $value);
                                            echo '<span class="old-value">' . htmlspecialchars($old) . '</span>';
                                            echo '<span class="arrow">→</span>';
                                            echo '<span class="new-value">' . htmlspecialchars($new) . '</span>';
                                        } else {
                                            echo htmlspecialchars($value);
                                        }
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($pages > 1): ?>
            <div class="pagination">
                <?php if ($current_page > 1): ?>
                    <a href="?controller=historique&page=<?= $current_page - 1 ?>" class="page-link">&laquo; Précédent</a>
                <?php endif; ?>

                <?php
                $start = max(1, $current_page - 2);
                $end = min($pages, $current_page + 2);

                if ($start > 1) {
                    echo '<a href="?controller=historique&page=1" class="page-link">1</a>';
                    if ($start > 2) {
                        echo '<span class="page-dots">...</span>';
                    }
                }

                for ($i = $start; $i <= $end; $i++) {
                    $class = $i === $current_page ? 'page-link active' : 'page-link';
                    echo '<a href="?controller=historique&page=' . $i . '" class="' . $class . '">' . $i . '</a>';
                }

                if ($end < $pages) {
                    if ($end < $pages - 1) {
                        echo '<span class="page-dots">...</span>';
                    }
                    echo '<a href="?controller=historique&page=' . $pages . '" class="page-link">' . $pages . '</a>';
                }
                ?>

                <?php if ($current_page < $pages): ?>
                    <a href="?controller=historique&page=<?= $current_page + 1 ?>" class="page-link">Suivant &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once "view_end.php" ?>