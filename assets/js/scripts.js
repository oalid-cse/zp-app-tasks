let fonts = [];
function showSuccessAlert(text, title="Success") {
    Swal.fire({
        title: title,
        text: text,
        icon: "success"
    });
}
function showErrorAlert(text, title="Oops!") {
    Swal.fire({
        title: title,
        text: text,
        icon: "error"
    });
}
$(document).ready(function () {
    loadFontList();
});

$('#fontInput').on('change', function () {
    let fileData = new FormData();
    let file = $(this)[0].files[0];
    fileData.append('font', file);

    $.ajax({
        url: 'api/upload-font.php',
        type: 'POST',
        data: fileData,
        contentType: false,
        processData: false,
        success: function (response) {
            let data = JSON.parse(response);
            if (data.status == 200) {
                loadFontList();
                showSuccessAlert(data.msg);
            } else {
                showErrorAlert(response.msg);
            }
        }
    });
});

function loadFontList() {
    let fontListTable = $("#fontListTable");
    $.ajax({
        url: 'api/get-fonts.php',
        type: 'GET',
        success: function (response) {
            response = JSON.parse(response);
            let fontListHTML = '';
            fonts = response.fonts;

            response.fonts.forEach(function (font, index) {
                let fontName = 'zepto-font' + index;
                let fontStyle = `
                    <style>
                        @font-face {
                            font-family: '${fontName}';
                            src: url('uploads/fonts/${font.file}');
                        }
                        .preview-font-${index} {
                            font-family: '${fontName}';
                        }
                    </style>
                `;
                $('head').append(fontStyle);

                fontListHTML += `
                        <tr>
                            <td>${font.name}</td>
                            <td><span style="font-family: '${fontName}';">Example Style</span></td>
                            <td><a href="javascript:void(0);" onclick="deleteFont(${font.id})" class="text-danger">Delete</a></td>
                        </tr>
                        `;
            });
            fontListTable.find('tbody').html(fontListHTML);

            loadSelectFont(response.fonts);
        }
    });
}

function deleteFont(id) {
    Swal.fire({
        title: "Do you want to delete this group?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yes, Delete!",
        denyButtonText: `No, Cancel!`
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: 'api/delete-font.php',
                type: 'POST',
                data: {delete: id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 200) {
                        loadFontList();
                        showSuccessAlert(response.msg);
                    } else {
                        showErrorAlert(response.msg);
                    }
                }
            });
        } else if (result.isDenied) {

        }
    });

}
