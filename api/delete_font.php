<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $pdo = Database::connect();

    // Deleting font
    $stmt = $pdo->prepare("DELETE FROM fonts WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    echo json_encode(['success' => true]);
}