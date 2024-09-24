<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
use OalidCse\Controllers\FontGroupController;
require_once '../app/Controllers/FontGroupController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['font_ids'])){
    $font = new FontGroupController();

    $response = $font->storeFontGroup($_POST);
    echo json_encode($response);
    exit();
}
