<?php
// Database configuration
const DB_HOST = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '123456';
const DB_NAME = 'zepto_apps_font_system_task';
const DB_PORT = '3306';
const DIRECTORY = __DIR__;


// Database connection
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
