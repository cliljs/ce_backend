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
				$res['success']  = 1;
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
    
    case 'account_position':
        $job_positions = $account_model->get_job_positions();

        echo json_encode([
            "data"      => array_column($job_positions, 'job_position'),
            "success"   => 1,
            "action"    => "AccountController/?action=account_position"
        ]);
        break;
    
    case 'account_list':

        echo json_encode([
            "data"      => $account_model->get_account_list(),
            "success"   => 1,
            "action"    => "AccountController/?action=account_list"
        ]);
        exit;
        break;
    
    case 'account_logout':
        session_regenerate_id();

        session_destroy();
        setcookie("PHPSESSID","",time()-3600,"/"); // delete session cookie

        echo json_encode([
            "logout"  => 1,
            "success" => 1
        ]);
        exit;
        break;
    
    default:
        break;
}