<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
use OalidCse\Controllers\FontGroupController;
require_once '../app/Controllers/FontGroupController.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $font = new FontGroupController();

    $response = $font->getFontGroups();
    echo json_encode($response);
    exit();
}
