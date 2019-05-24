FILES = new Array();

// On Document Ready
$(function(){

    // on file browse selection
    $("#midiUploads").on('change', function(e)
    {
        // get the files of the input and add to display/array
        add_files($(this).prop('files'));
    });

    // on file remove click
    $(document).on('click', '.uploaded-file > .icon-trash', function() {
        // get file id and remove
        remove_file(parseInt($(this).parent().attr("file-id")));
    });

    // on midi upload submit
    $(document).on('submit', '#midi-upload-form', function(e) {
        e.preventDefault();
        $("#submit").attr("disabled", true);

        if(FILES.length > 0) {
            console.log("Submitting playlist...");

            // Verify window has formdata api
            var form_data = false;
            if(window.FormData) { form_data = new FormData(); }

            if(form_data)
            {
                // Get playlist name
                let playlistName = $('#playlistName').val();
                form_data.append('playlistName', playlistName);
                // Get path for files on the users end
                let pathName = $('#pathName').val();
                form_data.append('pathName', pathName);

                // For each file in FILES
                for (var fileindex = 0; fileindex < FILES.length; fileindex++)
                {
                    form_data.append('files[]', FILES[fileindex]);
                }

                // make ajax call
                $.ajax({
                    url: 'generate_playlist.php',
                    type: 'POST',
                    data: form_data,
                    dataType: 'text',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(`Playlist created: ${response}`);

                        // construct blob
                        var blob = new Blob([response], {type: 'text/xml'});

                        // create link to item -> click link -> remove link
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = playlistName + ".xml";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        // clear cache and display
                        clear(true, true); reset();
                        $("#submit").removeAttr("disabled");
                    },
                    fail: function(jqHXR, status, error) {
                        console.log(error);
                    }
                });
            }
            else
            {
                alert("Your device does not support file uploads!");
            }
        }
        else {
            alert("Please upload at least 1 MIDI file to create a playlist!");
        }
    });
});

function add_files(file_arr)
{
    // clear files and display
    clear(true, true);
    // Save files to cache
    for(var i=0; i < file_arr.length; i++) { FILES.push(file_arr[i]); }
    // Display new files
    refresh_display();
}

// Displays a file in the selected-files display
function display_file(file, id)
{
    let new_file_elm = 
        `<div class="uploaded-file" file-id="${id}">` +
        `<i class="icon-trash" title="Delete?" alt="Delete?"></i>` +
        `${file.name}` +
        `</div>`;
    $(".selected-files").append(new_file_elm);
}

// Removes a file from the display and cache
function remove_file(id)
{
    // remove from arr
    FILES.splice(id, 1);
    // clear display but not all files
    clear(false, true);
    FILES.length > 0 ? refresh_display() : reset();
}

// Loop through current FILES array and display
function refresh_display()
{
    // add files to display
    for (var i = 0; i < FILES.length; i++)
    {
        display_file(FILES[i], i);
    }
    console.log("File display refreshed");
}

// Clears the display of files
// If clear_files is true, the cache will also clear
// If clear_display is true, the display will also clear
function clear(clear_files, clear_display)
{
    if(clear_files === undefined || clear_files === null) clear_files = true;
    if(clear_display === undefined || clear_display === null) clear_files = true;
    if(clear_files === true) {
        FILES = new Array();
        console.log("File cache cleared");
    }
    if(clear_display === true) {
        $(".selected-files").html('');
        console.log("File display cleared");
    }
}

function reset() { reset_display(); reset_input_files(); console.log("Fully reset"); }
function reset_display() { $(".selected-files").html('<div class="uploaded-file">Upload some MIDI files to get started!</div>'); }
function reset_input_files() { $("#midiUploads").val(""); }