<?php
require_once '../includes/db.php';

if (isset($_FILES['font']) && $_FILES['font']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['font']['tmp_name'];
    $fileName = $_FILES['font']['name'];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    if (strtolower($ext) !== 'ttf') {
        echo json_encode(['success' => false, 'message' => 'Only .ttf fonts are allowed.']);
        exit;
    }

    $newName = uniqid() . '.ttf';
    $targetDir = '../assets/fonts/';
    $targetPath = $targetDir . $newName;

    if (!move_uploaded_file($fileTmp, $targetPath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to upload font.']);
        exit;
    }

    // Insert into DB
    $pdo = Database::connect();
    $stmt = $pdo->prepare("INSERT INTO fonts (font_name, font_file) VALUES (?, ?)");
    $stmt->execute([$fileName, $newName]);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error.']);
}