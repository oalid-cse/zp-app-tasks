<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
use OalidCse\Controllers\FontGroupController;
require_once '../app/Controllers/FontGroupController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])){
    $font = new FontGroupController();

    $response = $font->deleteFontGroup($_POST['delete']);
    echo json_encode($response);
    exit();
}
