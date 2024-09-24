<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Group System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Font Group System</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">
                Upload Font (Only .ttf)
            </h5>
        </div>
        <div class="card-body text-center">
            <form id="fontUploadForm" enctype="multipart/form-data">
                <label for="fontInput" class="file-drop-area">
                    <p>Drag & Drop files here or click to upload</p>
                    <input type="file" id="fontInput" accept=".ttf" hidden>
                </label>
            </form>
            <small class="text-muted">Fonts will be uploaded automatically when selected.</small>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Uploaded Fonts
            </h5>

        </div>
        <div class="card-body" id="fontList">
            <div class="table-wrapper">
                <table class="table table-striped" id="fontListTable">
                    <thead>
                    <tr>
                        <th>Font Name</th>
                        <th>Preview</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-4 createFontGroupCard" id="createFontGroupCard">
        <div class="card-header">
            <h5 class="card-title">
                Create Font Group
            </h5>
            <div class="tools">
                <button type="button" class="btn back-to-create d-none" onclick="backToCreateFontGroup()">Back To Create</button>
            </div>
        </div>
        <div class="card-body">
            <form id="fontGroupForm">
                <div class="mb-3">
                    <label for="groupName" class="form-label">Group Name</label>
                    <input type="text" class="form-control" id="groupName" name="name" required>
                </div>
                <div class="font-group-item-wrapper">

                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" onclick="addGroupItem()" class="btn btn-outline-success">Add Row</button>
                    <button type="submit" class="btn btn-success fontGroupCreateBtn">Create</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4 mb-5">
        <div class="card-header">
            <h5 class="card-title">
                Font Groups
            </h5>
        </div>
        <div class="card-body">
            <div class="table-wrapper">
                <table class="table table-striped" id="fontGroupList">
                    <thead>
                    <tr>
                        <th>NAME</th>
                        <th>FONTS</th>
                        <th class="text-center">COUNT</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="hidden-item" class="d-none">
        <div id="groupItem">
            <div class="font-group-item">
                <div class="form-group font-list">
                    <label class="form-label">Select Fonts</label>
                    <select class="form-select fontSelect" name="font_ids[]" required
                            onchange="selectGroupFont(this)"></select>
                </div>
                <div class="form-group font-name">
                    <label class="form-label">Font Name</label>
                    <input type="text" class="form-control font-name" disabled>
                </div>
                <div class="action">
                    <button type="button" class="font-group-item-delete" onclick="deleteGroupItem(this)">
                        X
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/scripts.js"></script>
    <script src="./assets/js/droparea-handler.js"></script>

</body>
</html>
