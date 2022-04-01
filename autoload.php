<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('CONTROLLER_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/controllers/');

define('DB_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/controllers/DatabaseController.php');

define('MODEL_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/models/');

define('UPLOAD_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/uploads/');

// CONSTANTS FOR TRIAL IWAS SCAM
define('BLOCK_REQUEST', FALSE);
define('FOR_TRIAL', TRUE);

// DEPENDENCIES
include_once DB_PATH;
// include_once CONTROLLER_PATH . '/MailController.php';
include_once CONTROLLER_PATH . 'HelperController.php';
include_once CONTROLLER_PATH . 'TrialController.php';

// SERVES REQUEST CONTROLLER
$request_controller = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if (file_exists(CONTROLLER_PATH . $request_controller)) {
    include_once  CONTROLLER_PATH .  $request_controller; 
} 

$db  = new DatabaseController();

if (BLOCK_REQUEST) {
    echo json_encode(["msg" => "ABA BAYAD MUNA"]);
    exit;
}

// PWEDE MO KUYA DITO WAG ISAMA LOGIN $request_controller === 'AccountController.php'
if (FOR_TRIAL && !empty($_POST)) {
    $trial_status = $trial_controller->count_request();

    if (!$trial_status) {
        echo json_encode(["msg" => "ABA BAYAD MUNA"]);
        exit;
    }
}