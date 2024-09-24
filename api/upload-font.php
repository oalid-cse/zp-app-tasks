<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use OalidCse\ZeptoAppsAssignments\Controllers\FontController;

require_once '../app/Controllers/FontController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['font'])) {
    $font = new FontController();

    $response = $font->uploadFont($_FILES['font']);
    echo json_encode($response);
    exit();
}
