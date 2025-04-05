$(document).ready(function () {
    $('#fontFile').on('change', function () {
      const file = this.files[0];
      if (!file || file.type !== 'font/ttf' && !file.name.endsWith('.ttf')) {
        alert('Please upload a .ttf file only.');
        return;
      }
  
      const formData = new FormData();
      formData.append('font', file);
  
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
  
    // Load uploaded fonts
    function loadFonts() {
      $.get('api/get_fonts.php', function (res) {
        $('#fontList').html(res);
      });
    }
  
    // Call it once on page load
    loadFonts();
  });





  // Load font options into the dropdowns
function loadFontOptions(callback) {
    // $.get('api/get_fonts.php', function (res) {
    //   const tempDiv = $('<div>').html(res);
    //   const selects = tempDiv.find('select.font-select');
  
    //   // Generate option list
    //   let options = '<option value="">Select Font</option>';
    //   tempDiv.find('div').each(function () {
    //     const fontName = $(this).find('strong').text();
    //     const fontId = fontName.match(/(\d+)/g)?.[0]; // extract ID
    //     if (fontId) {
    //       options += `<option value="${fontId}">${fontName}</option>`;
    //     }
    //   });
  
    //   $('.font-select').html(options);
    //   if (callback) callback();
    // });
    $.get('api/get_font_options.php', function (options) {
      $('.font-select').each(function () {
        $(this).html('<option value="">Select Font</option>' + options);
      });
      if (callback) callback();
    });
  }
  
  // Add Row
  $('#addRow').on('click', function () {
    const newRow = `<div class="font-row">
      <select name="fonts[]" class="font-select">
        <!-- Options will be added -->
      </select>
      <button type="button" class="removeRow">Remove</button>
    </div>`;
    $('#fontRows').append(newRow);
    loadFontOptions();
  });
  
  // Remove Row
  $(document).on('click', '.removeRow', function () {
    $(this).closest('.font-row').remove();
  });
  
  // Create Group Submit
  $('#fontGroupForm').on('submit', function (e) {
    e.preventDefault();
  
    const fontCount = $('.font-select').length;
    const selectedFonts = $('.font-select').map(function () {
      return $(this).val();
    }).get().filter(Boolean);
  
    if (selectedFonts.length < 2) {
      $('#groupStatus').html('<p style="color:red;">Select at least 2 fonts to create a group.</p>');
      return;
    }
  
    const formData = $(this).serialize();
  
    $.post('api/create_group.php', formData, function (res) {
      const data = JSON.parse(res);
      if (data.success) {
        $('#groupStatus').html('<p style="color:green;">' + data.message + '</p>');
        $('#fontGroupForm')[0].reset();
        $('#fontRows').html('<div class="font-row"><select name="fonts[]" class="font-select"></select></div>');
        $('#groupId').remove(); // remove hidden field
        $('#fontGroupForm button[type="submit"]').text('Create Group');
        loadFontOptions();
        loadGroups();
      } else {
        $('#groupStatus').html('<p style="color:red;">' + data.message + '</p>');
      }
    });
  });
  
  // Load groups
  function loadGroups() {
    $.get('api/get_groups.php', function (res) {
      $('#fontGroupList').html(res);
    });
  }
  
  // Init
  loadFontOptions();
  loadGroups();


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

  

  $(document).on('click', '.editGroup', function () {
    const groupId = $(this).data('id');
  
    $.get('api/get_group_by_id.php', { id: groupId }, function (res) {
      const data = JSON.parse(res);
      if (data.success) {
        // Update form for editing
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
          $('#fontGroupForm').append('<input type="hidden" id="groupId" name="group_id" value="' + groupId + '">');
        } else {
          $('#groupId').val(groupId);
        }
  
        // Change button text
        $('#fontGroupForm button[type="submit"]').text('Update Group');
      }
    });
  });