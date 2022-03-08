<?php

include_once '../models/AccountModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'account_login':
            $is_auth = $account_model->login($_POST);

            $res = ["action" => "AccountController/?action=account_login"];
            if (array_key_exists("exists", $is_auth) && !$is_auth['exists']) {
				$res['success']  = 0;
			} else {
				$res['success']  = 0;
                $res['data']     =  $is_auth;
            }

            echo json_encode($res);
            exit;
        break;
    
    default:
        break;
}