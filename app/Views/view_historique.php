<?php require_once "view_begin.php" ?>

<link rel="stylesheet" href="Content/css/historique.css">

<div class="container">
    <h1>Historique des actions</h1>
    <div class="historique-container">
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
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "view_end.php" ?>