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
                    <input type="file" id="fontInput" accept=".ttf" multiple hidden>
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
                    <tr>
                        <td>Font 0</td>
                        <td><span >Example Style</span></td>
                        <td><a href="javascript:void(0);" onclick="deleteFont(1)" class="text-danger">Delete</a></td>
                    </tr>

                    <tr>
                        <td>Font 1</td>
                        <td><span >Example Style</span></td>
                        <td><a href="javascript:void(0);" onclick="deleteFont(2)" class="text-danger">Delete</a></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/scripts.js"></script>

</body>
</html>
