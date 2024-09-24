<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use OalidCse\ZeptoAppsAssignments\Controllers\FontController;

require_once '../app/Controllers/FontController.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $font = new FontController();

    $response = $font->getFonts();
    echo json_encode($response);
    exit();
}
