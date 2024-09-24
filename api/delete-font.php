<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use OalidCse\Controllers\FontController;

require_once '../app/Controllers/FontController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $font = new FontController();

    $response = $font->deleteFont($_POST['delete']);
    echo json_encode($response);
    exit();
}
