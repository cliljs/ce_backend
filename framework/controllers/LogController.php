<?php

include_once '../models/LogModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';


switch ($act) {
    case 'create_daily':
        $_POST['is_daily_log'] = 1;

        $new_log =  $log_model->create_log($_POST, $_FILES);

        echo json_encode([
                "success" => 1,
                "data"    => $new_log,
                "action"  => "LogController/action=create_log"
        ]);
        exit;
        break;

    case 'create_maintenance':
        $_POST['is_daily_log'] = 0;

        $new_log =  $log_model->create_log($_POST, $_FILES);

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
            $res_data = $log_model->get_logs();
        } else {
             // GET MAINTENANCE LOGS
            $res_data = $log_model->get_logs(0);
        }
        
        echo json_encode([
            "success" => 1,
            "data"    => $res_data,
            "action"  => "LogController/action=get_logs"
        ]);
        exit;
        break;

    
    default:
        # code...
        break;
}