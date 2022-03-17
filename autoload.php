<?php
session_start();
//Load Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

define('CONTROLLER_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/controllers/');

define('DB_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/controllers/DatabaseController.php');

define('MODEL_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/models/');

define('UPLOAD_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/uploads/');

define('BLOCK_REQUEST', FALSE);

// DEPENDENCIES
include_once DB_PATH;
// include_once CONTROLLER_PATH . '/MailController.php';
include_once CONTROLLER_PATH . 'HelperController.php';

// SERVES REQUEST CONTROLLER
$request_controller = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if (file_exists(CONTROLLER_PATH . $request_controller)) {
    include_once  CONTROLLER_PATH .  $request_controller; 
} 

$db = new DatabaseController();

// MIDDLEWARE FOR ROUTING
// $dont_include = [
//                 "action=account_login",
//                 "action=account_register",
//                 "action=account_logout", 
//             ];

// if ($request_controller <> "test.php") {
//     if (empty($_SESSION) && !in_array($_SERVER['QUERY_STRING'], $dont_include)) {
//         echo json_encode(["msg" => "nu gawa mo dito bay"]);
//         exit;
//     }
// }

if (BLOCK_REQUEST) {
    echo json_encode(["msg" => "ABA BAYAD MUNA"]);
    exit;
}