<?php
  require_once 'includes/db.php'; // Ensure this path is correct

  $pdo = Database::connect();
  $stmt = $pdo->query("SELECT * FROM fonts ORDER BY id DESC");
  $fonts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
    <?php
    foreach ($fonts as $font) {
      $fontPath = '/myproject/assets/fonts/' . $font['font_file'];
      // echo "
      //   @font-face {
      //     font-family: 'font_{$font['id']}';
      //     src: url('$fontPath');
      //   }
      // ";
    }
    ?>
</head>

<body>
    <!-- <h2 class="upload-font-text">Upload Font (.ttf only)</h2> -->
    <!-- <input type="file" id="fontFile" accept=".ttf" /> -->





    <div class="page-center-wrapper">
        <div class="upload-container">
            <input type="file" id="fontFile" accept=".ttf" class="upload-input" />
            <p class="upload-text"><b>Click to upload</b> or drag and drop<br>Only TTF File Allowed</p>
        </div>
    </div>





    <div id="uploadStatus"></div>
    
    <hr>

    <div id="fontList"></div>


    <hr>

    <h3>Create Font Group</h3>
    <form id="fontGroupForm">
        <input type="text" name="group_name" placeholder="Group Name" required><br><br>

        <div id="fontRows">
            <div class="font-row">
                <select name="fonts[]" class="font-select">
                    <!-- Will be filled by JS -->
                </select>
            </div>
        </div>

        <button type="button" id="addRow">Add Row</button>
        <button type="submit">Create Group</button>
    </form>

    <div id="groupStatus"></div>

    <hr>

    <h3>All Font Groups</h3>
    <div id="fontGroupList"></div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/app.js"></script>

</body>

</html>