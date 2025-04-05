<?php
require_once '../includes/db.php';

if (isset($_GET['id'])) {
    $pdo = Database::connect();

    $stmt = $pdo->prepare("SELECT * FROM font_groups WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $group = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($group) {
        $stmt2 = $pdo->prepare("SELECT font_id FROM font_group_items WHERE group_id = ?");
        $stmt2->execute([$group['id']]);
        $fontIds = array_column($stmt2->fetchAll(PDO::FETCH_ASSOC), 'font_id');

        echo json_encode([
            'success' => true,
            'group' => $group,
            'fonts' => $fontIds
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Group not found.']);
    }
}
