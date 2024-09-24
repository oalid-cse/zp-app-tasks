$(document).ready(function () {
    var dropArea = $('.file-drop-area');

    // Prevent default drag behaviors
    $(document).on('dragenter dragover dragleave drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Add a class when dragging over
    dropArea.on('dragover', function () {
        $(this).addClass('dragover');
    });

    // Remove the class when dragging leaves
    dropArea.on('dragleave', function () {
        $(this).removeClass('dragover');
    });

    // Handle file drop
    dropArea.on('drop', function (e) {
        var files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
        $(this).removeClass('dragover');
    });

    // Handle file selection via input
    $('#fontInput').on('change', function () {
        var files = this.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        $('#filePreview').empty();  // Clear previous previews
        Array.from(files).forEach(file => {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = $('<img>').attr('src', e.target.result);
                $('#filePreview').append(img);
            }
            reader.readAsDataURL(file);  // Read the file for preview
        });
    }
});
