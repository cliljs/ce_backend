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
    case 'account_create': 
        $new_account = $account_model->profile_create($_POST);

        echo json_encode([
            "insert_id" => $new_account,
            "success"   => 1,
            "action"    => "AccountController/?action=account_login"
        ]);
        exit;
        break;

    case 'account_update':
        $updated_account = $account_model->profile_update();

        echo json_encode([
            "data"      => $updated_account,
            "success"   => 1,
            "action"    => "AccountController/?action=account_login"
        ]);
        exit;
        break;
    
    case 'account_logout':
        echo json_encode([
            "logout"  => session_destroy(),
            "success" => 1
        ]);
        exit;
        break;
    
    default:
        break;
}