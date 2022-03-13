<?php

include_once '../models/ComputeModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'create_compute':
        $new_compute = $compute_model->create_compute($_POST);

        echo json_encode([
            "success"   => $new_compute > 0 ? 1 : 0,
            "insert_id" => $new_compute,
            "action"    => "ComputeController/action=create_compute"  
        ]);
        exit;
        break;

    case 'update_compute':
        $new_compute = $compute_model->update_compute($_POST);

        echo json_encode([
            "success"    => intval($new_compute) > 0 ? 1 : 0,
            "updated_id" => $new_compute,
            "action"     => "ComputeController/action=update_compute"  
        ]);
        exit;
        break;

    case 'get_compute_list':
        $result = $compute_model->get_compute_list($_GET);

        echo json_encode([
            "success"    => 1,
            "data"       => $result,
            "action"     => "ComputeController/action=get_compute_list"  
        ]);
        exit;
        break;
    
    
    default:
        break;
}

