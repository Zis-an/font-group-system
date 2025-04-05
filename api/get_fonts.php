<?php
require_once '../includes/db.php';

$pdo = Database::connect();
$stmt = $pdo->query("SELECT * FROM fonts ORDER BY id DESC");
$fonts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($fonts as $font) {
    $fontPath = '../assets/fonts/' . $font['font_file'];
    echo "<style>
        @font-face {
            font-family: 'font_{$font['id']}';
            src: url('$fontPath');
        }
    </style>";
    echo "<div style='margin-bottom: 10px;'>
        <strong>{$font['font_name']}</strong><br/>
        <p style='font-family: font_{$font['id']}; font-size: 20px;'>Preview: The quick brown fox jumps over the lazy dog.</p>
    </div>";
}