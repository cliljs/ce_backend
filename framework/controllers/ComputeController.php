<?php

include_once '../models/ComputeModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'create_compute':
        $new_compute = $compute_model->create_compute($_POST);

        echo json_encode([
            "success"   => 1,
            "insert_id" => $new_compute,
            "action"    => "ComputeController/action=create_compute"
        ]);
        exit;
        break;

    case 'update_compute':
        $updated_compute = $compute_model->update_compute($_POST);

        echo json_encode([
            "success"    => intval($updated_compute) > 0 ? 1 : 0,
            "updated_id" => $updated_compute,
            "action"     => "ComputeController/action=update_compute"
        ]);
        exit;
        break;

    case 'get_compute_list':
        $result = $compute_model->get_compute_project($_GET['id']);

        echo json_encode([
            "success"    => 1,
            "data"       => $result,
            "action"     => "ComputeController/action=get_compute_list"
        ]);
        exit;
        break;

    case 'get_compute_list_cat':
        unset($_GET['action']);
        $result = $compute_model->get_compute_by_cat($_GET);

        echo json_encode([
            "success"    => 1,
            "data"       => $result,
            "action"     => "ComputeController/action=get_compute_list_cat"
        ]);
        exit;
        break;

    case 'get_compute_list_all':
        unset($_GET['action']);
        $result = $compute_model->get_compute_all($_GET);

        echo json_encode([
            "success"    => 1,
            "data"       => $result,
            "action"     => "ComputeController/action=get_compute_list_all"
        ]);
        exit;
        break;
    case 'get_default_values':
        $result = $compute_model->get_default_values();
        echo json_encode([
            "success"    => 1,
            "data"       => $result,
            "action"     => "ComputeController/action=get_default_values"
        ]);
        exit;
        break;
    default:
        break;
}
