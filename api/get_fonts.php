<?php
require_once '../includes/db.php';

$pdo = Database::connect();
$stmt = $pdo->query("SELECT * FROM fonts ORDER BY id DESC");
$fonts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug to check the fonts array
// echo "<pre>".print_r($fonts)."</pre>";

// Start the HTML structure
echo "<h3>Our Fonts</h3>";
echo "<small>Browse a list of Zepto fonts to build your font group.</small>";
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>FONT NAME</th>";
echo "<th>PREVIEW</th>";
echo "<th>ACTION</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Add the @font-face CSS rules to the head to ensure the fonts are available
echo "<style>";
foreach ($fonts as $font) {
    $fontPath = '/font-group-system/assets/fonts/' . $font['font_file'];
    // Define the font-family using 'font_' prefix
    echo "
        @font-face {
            font-family: 'font_{$font['id']}';  /* Using font ID instead of font name to avoid clashes */
            src: url('$fontPath');
        }
    ";
}
echo "</style>";

// Loop through each font and create the table row
foreach ($fonts as $font) {
    echo "<tr>";
    echo "<td>{$font['font_name']}</td>";
    // Use the font-family 'font_{$font['id']}' in the preview
    echo "<td><p class='font-preview' style='font-family: font_{$font['id']}'>Example Style</p></td>";
    echo "<td><button class='delete-btn' data-font-id='{$font['id']}'>Delete</button></td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";