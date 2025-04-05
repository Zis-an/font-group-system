<?php
require_once '../includes/db.php';

$pdo = Database::connect();
$stmt = $pdo->query("SELECT id, font_name FROM fonts ORDER BY id DESC");
$fonts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($fonts as $font) {
    echo "<option value='{$font['id']}'>{$font['font_name']}</option>";
}
