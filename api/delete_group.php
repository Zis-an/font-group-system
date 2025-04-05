<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $pdo = Database::connect();

    // Deleting group (font_group_items will auto delete due to FK)
    $stmt = $pdo->prepare("DELETE FROM font_groups WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    echo json_encode(['success' => true]);
}
