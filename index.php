<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<h2>Upload Font (.ttf only)</h2>
<input type="file" id="fontFile" accept=".ttf" />
<div id="uploadStatus"></div>

<hr>

<h3>Uploaded Fonts</h3>
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