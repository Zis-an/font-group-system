<?php
require_once '../includes/db.php';

$pdo = Database::connect();
$stmt = $pdo->query("SELECT * FROM font_groups ORDER BY id DESC");
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($groups as $group) {
    echo "<div class='group-box'>";
    echo "<div class='group-header'><strong>{$group['group_name']}</strong></div>";

    $stmt2 = $pdo->prepare("SELECT f.font_name FROM font_group_items i JOIN fonts f ON i.font_id = f.id WHERE i.group_id = ?");
    $stmt2->execute([$group['id']]);
    $fonts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='group-fonts'><strong>Fonts:</strong> ";
    if ($fonts) {
        $fontNames = array_map(fn($f) => $f['font_name'], $fonts);
        echo implode(", ", $fontNames);
    } else {
        echo "<em>No fonts assigned</em>";
    }
    echo "</div>";

    echo "<div class='group-actions'>
        <button data-id='{$group['id']}' class='editGroup'>Edit</button>
        <button data-id='{$group['id']}' class='deleteGroup'>Delete</button>
    </div>";

    echo "</div>";
}
