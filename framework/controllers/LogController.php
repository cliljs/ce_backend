<?php

include_once '../models/LogModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';


switch ($act) {
    case 'create_daily':
        $_POST['is_daily_log'] = 1;

        $new_log =  $log_model->create_log($_POST);

        echo json_encode([
                "success" => 1,
                "data"    => $new_log,
                "action"  => "LogController/action=create_log"
        ]);
        exit;
        break;

    case 'create_maintenance':
        $_POST['is_daily_log'] = 0;

        $new_log =  $log_model->create_log($_POST);

        echo json_encode([
                "success" => 1,
                "data"    => $new_log,
                "action"  => "LogController/action=create_maintenance"
        ]);
        exit;
        break;

    case 'get_logs':

        $res_data = null;
        if (intval($_GET['type']) === 1) {
             // GET DAILY LOGS
            $res_data = $log_model->get_logs(1, $_POST['user_id']);
        } else {
             // GET MAINTENANCE LOGS
            $res_data = $log_model->get_logs(0, $_POST['user_id']);
        }
        
        echo json_encode([
            "success" => 1,
            "data"    => $res_data,
            "action"  => "LogController/action=get_logs"
        ]);
        exit;
        break;

    case 'get_row_log':
    
        echo json_encode([
            "success" => 1,
            "data"    => $log_model->get_log_row($_GET['id']),
            "action"  => "LogController/action=get_row_log"
        ]);
        exit;
        break;

    
    default:
        # code...
        break;
}