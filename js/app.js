$(document).ready(function () {
  // Initialize functions on page load
  loadFonts();
  loadFontOptions();
  loadGroups();

  // Font upload and loading
  handleFontUpload();
  // Font delete functionality
  handleFontDelete();
  // Font group management
  handleGroupActions();
});



// ========================== //
// Handle Font Upload         //
// ========================== //
function handleFontUpload() {
  $('#fontFile').on('change', function () {
    const file = this.files[0];

    // Check if file is a .ttf
    if (!file || file.type !== 'font/ttf' && !file.name.endsWith('.ttf')) {
      alert('Please upload a .ttf file only.');
      return;
    }

    const formData = new FormData();
    formData.append('font', file);

    // AJAX request to upload font
    $.ajax({
      url: 'api/upload_font.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        const data = JSON.parse(res);
        if (data.success) {
          $('#uploadStatus').html('<p style="color:green;">Font uploaded successfully!</p>');
          loadFonts();
        } else {
          $('#uploadStatus').html('<p style="color:red;">' + data.message + '</p>');
        }
      },
      error: function () {
        $('#uploadStatus').html('<p style="color:red;">Something went wrong!</p>');
      }
    });
  });
}



// ========================== //
// Load Fonts Functionality   //
// ========================== //
function loadFonts() {
  $.get('api/get_fonts.php', function (res) {
    $('#fontList').html(res);
  });
}



// ========================== //
// Handle Font Deletion       //
// ========================== //
function handleFontDelete() {
  $(document).on('click', '.delete-btn', function () {
    const fontId = $(this).data('font-id'); // Get the font ID from the data-font-id attribute
    
    // Confirm before deletion
    if (confirm('Are you sure you want to delete this font?')) {
      $.ajax({
        url: 'api/delete_font.php',
        method: 'POST',
        data: { id: fontId },
        success: function (response) {
          const result = JSON.parse(response);
          if (result.success) {
            // On success, remove the font row from the table
            $('button[data-font-id="' + fontId + '"]').closest('tr').remove();
          } else {
            alert('Failed to delete the font.');
          }
        },
        error: function () {
          alert('An error occurred while deleting the font.');
        }
      });
    }
  });
}




// ========================== //
// Load Font Options          //
// ========================== //
function loadFontOptions(callback) {
  $.get('api/get_font_options.php', function (options) {
    $('.font-select').each(function () {
      $(this).html('<option value="">Select Font</option>' + options);
    });
    if (callback) callback();
  });
}




// ========================== //
// Add/Remove Font Rows       //
// ========================== //
$('#addRow').on('click', function () {
  const newRow = `<div class="font-row">
    <select name="fonts[]" class="font-select"></select>
    <button type="button" class="removeRow">Remove</button>
  </div>`;
  $('#fontRows').append(newRow);
  loadFontOptions();
});

$(document).on('click', '.removeRow', function () {
  $(this).closest('.font-row').remove();
});




// ========================== //
// Handle Group Creation/Update //
// ========================== //
$('#fontGroupForm').on('submit', function (e) {
  e.preventDefault();

  const selectedFonts = $('.font-select').map(function () {
    return $(this).val();
  }).get().filter(Boolean);

  // Check if at least 2 fonts are selected
  if (selectedFonts.length < 2) {
    $('#groupStatus').html('<p style="color:red;">Select at least 2 fonts to create a group.</p>');
    return;
  }

  const formData = $(this).serialize();

  $.post('api/create_group.php', formData, function (res) {
    const data = JSON.parse(res);
    if (data.success) {
      $('#groupStatus').html('<p style="color:green;">' + data.message + '</p>');
      resetGroupForm();
      loadFontOptions();
      loadGroups();
    } else {
      $('#groupStatus').html('<p style="color:red;">' + data.message + '</p>');
    }
  });
});




// ========================== //
// Load Groups Functionality  //
// ========================== //
function loadGroups() {
  $.get('api/get_groups.php', function (res) {
    $('#fontGroupList').html(res);
  });
}




// ========================== //
// Handle Group Actions (Edit/Delete) //
// ========================== //
function handleGroupActions() {
  // Delete group action
  $(document).on('click', '.deleteGroup', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure?')) {
      $.post('api/delete_group.php', { id }, function (res) {
        const data = JSON.parse(res);
        if (data.success) {
          loadGroups();
        }
      });
    }
  });

  // Edit group action
  $(document).on('click', '.editGroup', function () {
    const groupId = $(this).data('id');
  
    $.get('api/get_group_by_id.php', { id: groupId }, function (res) {
      const data = JSON.parse(res);
      if (data.success) {
        updateGroupForm(data);
      }
    });
  });
}




// ========================== //
// Reset Group Form          //
// ========================== //
function resetGroupForm() {
  $('#fontGroupForm')[0].reset();
  $('#fontRows').html('<div class="font-row"><select name="fonts[]" class="font-select"></select></div>');
  $('#groupId').remove();
  $('#fontGroupForm button[type="submit"]').text('Create Group');
}




// ========================== //
// Update Group Form with Data //
// ========================== //
function updateGroupForm(data) {
  $('input[name="group_name"]').val(data.group.group_name);
  $('#fontRows').empty();

  data.fonts.forEach(fontId => {
    const row = `<div class="font-row">
      <select name="fonts[]" class="font-select"></select>
      <button type="button" class="removeRow">Remove</button>
    </div>`;
    $('#fontRows').append(row);
  });

  loadFontOptions(() => {
    $('.font-select').each((i, el) => {
      $(el).val(data.fonts[i]);
    });
  });

  // Add hidden field for group ID
  if ($('#groupId').length === 0) {
    $('#fontGroupForm').append('<input type="hidden" id="groupId" name="group_id" value="' + data.group.id + '">');
  } else {
    $('#groupId').val(data.group.id);
  }

  $('#fontGroupForm button[type="submit"]').text('Update Group');
}
