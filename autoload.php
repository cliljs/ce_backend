<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
define('PHPMAILER_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/vendor/PHPMailer/');

require  PHPMAILER_PATH . 'PHPMailer/src/Exception.php';
require  PHPMAILER_PATH . 'PHPMailer/src/PHPMailer.php';
require  PHPMAILER_PATH . 'PHPMailer/src/SMTP.php';

//Load Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

define('CONTROLLER_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/controllers/');

define('DB_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/controllers/DatabaseController.php');

define('MODEL_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/models/');

define('UPLOAD_PATH', rtrim(preg_replace('#[/\\\\]{1,}#', '/', realpath(dirname(__FILE__))), '/') . '/framework/uploads/');

// DEPENDENCIES
include_once DB_PATH;
// include_once CONTROLLER_PATH . '/MailController.php';
include_once CONTROLLER_PATH . 'HelperController.php';

// SERVES REQUEST CONTROLLER
$request_controller = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

if (file_exists(CONTROLLER_PATH . $request_controller)) {
    include_once  CONTROLLER_PATH .  $request_controller; 
} 

session_start();
    
$db         = new DatabaseController();
$php_mailer = new PHPMailer();

// Server settings
$php_mailer->isSMTP();
$php_mailer->Host       = 'smtp.gmail.com';
$php_mailer->SMTPAuth   = true;
$php_mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$php_mailer->Port       = 587;

// $mailer = new MailController($php_mailer);

// MIDDLEWARE FOR ROUTING
$dont_include = [
                "action=account_login",
                "action=account_register",
                "action=account_logout", 
            ];

if ($request_controller <> "test.php") {
    if (empty($_SESSION) && !in_array($_SERVER['QUERY_STRING'], $dont_include)) {
        echo json_encode(["msg" => "nu gawa mo dito bay"]);
        exit;
    }
}

