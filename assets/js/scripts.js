let fonts = [];
let font_groups = [];
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
    loadFontGroupList();
    addGroupItem();
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

$(document).on('submit', "#fontGroupForm", function (e) {
    e.preventDefault();
    storeFontGroup();
});
function storeFontGroup() {
    if ($('.font-group-item-wrapper .font-group-item').length < 2) {
        showErrorAlert('At least 2 fonts are required.');
        return;
    }
    if(($('#fontGroupId').length > 0) && ($('#fontGroupId').val() != '')) {
        updateFontGroup();
        return;
    }
    let fontGroupData = $('#fontGroupForm').serialize();
    $.ajax({
        url: 'api/store-font-groups.php',
        type: 'POST',
        data: fontGroupData,
        success: function (response) {
            response = JSON.parse(response);
            if (response.status == 200) {
                backToCreateFontGroup();
                loadFontGroupList();
                showSuccessAlert(response.msg);
            } else {
                showErrorAlert(response.msg);
            }
        }
    });
}

function loadSelectFont(fonts) {
    let fontSelectHTML = `<option value="" >Select Font</option>`;
    fonts.forEach(function (font) {
        fontSelectHTML += `
                    <option value="${font.id}" data-name="${font.name}">${font.name}</option>
                `;
    });
    $('.fontSelect').html(fontSelectHTML);
}

function updateFontGroup() {
    let fontGroupData = $('#fontGroupForm').serialize();
    $.ajax({
        url: 'api/update-font-groups.php',
        type: 'POST',
        data: fontGroupData,
        success: function (response) {
            response = JSON.parse(response);
            if (response.status == 200) {
                $('.font-group-item-wrapper').html('');
                $('#groupName').val('');
                backToCreateFontGroup();
                loadFontGroupList();
                showSuccessAlert(response.msg);
            } else {
                showErrorAlert(response.msg);
            }
        }
    });
}

function loadFontGroupList() {
    $.ajax({
        url: 'api/get-font-groups.php',
        type: 'GET',
        success: function (response) {
            response = JSON.parse(response);
            let fontGroupListHTML = '';
            font_groups = response.font_groups;
            response.font_groups.forEach(function (fontGroup) {
                fontGroupListHTML += `
                        <tr>
                            <td>${fontGroup.group_name}</td>
                            <td>
                                ${fontGroup.fonts.map(font => font.name).join(', ')}
                            </td>
                            <td class="text-center">${fontGroup.fonts.length}</td>
                            <td>
                                <a href="javascript:void(0);" onclick="editFontGroup(${fontGroup.id})" class="text-primary me-2">Edit</a>
                                <a href="javascript:void(0);" onclick="deleteFontGroup(${fontGroup.id})" class="text-danger">Delete</a>
                            </td>
                        </tr>
                        `;
            });
            $('#fontGroupList').find('tbody').html(fontGroupListHTML);
        }
    });
}

function deleteFontGroup(id) {
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
                url: 'api/delete-font-group.php',
                type: 'POST',
                data: {delete: id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 200) {
                        loadFontGroupList();
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

function editFontGroup(id) {
    let fontGroup = font_groups.find(group => group.id == id);
    if(!fontGroup) {
        showErrorAlert('Invalid Font group!');
        return;
    }
    $('#groupName').val(fontGroup.group_name);
    $('.font-group-item-wrapper').html('');
    $('.font-group-item-wrapper').html(`<input type="hidden" name="id" id="fontGroupId" value="${fontGroup.id}">`);
    fontGroup.fonts.forEach(font => {
        let groupItem = $('#groupItem').html();
        $('.font-group-item-wrapper').append(groupItem);
        $(".font-group-item-wrapper .font-group-item:last-child").find('input.font-name').val(font.name);
        $(".font-group-item-wrapper .font-group-item:last-child").find('select.fontSelect').val(font.id);
    });

    $(".createFontGroupCard .back-to-create").removeClass('d-none');
    $(".createFontGroupCard .card-title").html('Edit Font Group');
    $(".createFontGroupCard .fontGroupCreateBtn").html('Update');

    $('html, body').animate({
        scrollTop: $("#createFontGroupCard").offset().top
    }, 1000);
}

function backToCreateFontGroup() {
    $(".createFontGroupCard .back-to-create").addClass('d-none');
    $(".createFontGroupCard .card-title").html('Create Font Group');
    $(".createFontGroupCard .fontGroupCreateBtn").html('Create');

    $('#groupName').val('');
    $('.font-group-item-wrapper').html('');
    addGroupItem();
}

function addGroupItem() {
    let groupItem = $('#groupItem').html();
    $('.font-group-item-wrapper').append(groupItem);
}

function deleteGroupItem(element) {
    $(element).closest('.font-group-item').remove();
}

function selectGroupFont(element) {
    let fontName = $(element).find(':selected').data('name');
    $(element).closest('.font-group-item').find('.font-name input').val(fontName);
}
