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

    <?php include 'includes/_upload_fonts_form.php'; ?>

    <?php include 'includes/_uploaded_font_list.php'; ?>

    <hr class="mt-5 mb-5">

    <?php include 'includes/_create_font_group_form.php'; ?>

    <?php include 'includes/_font_group_list.php'; ?>

    <?php include 'includes/_font_group_new_item.php'; ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/scripts.js"></script>
    <script src="./assets/js/droparea-handler.js"></script>

</body>
</html>
