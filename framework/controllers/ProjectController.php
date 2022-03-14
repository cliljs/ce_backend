<?php

include_once '../models/ProjectModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'create_project':
        $new_project = $project_model->create_project($_POST);

        echo json_encode([
            "success"   => $new_project > 0 ? 1 : 0,
            "insert_id" => $new_project,
            "action"    => "ProjectController/action=create_project"
        ]);
        exit;
        break;

    case 'update_project':
        $new_project = $project_model->update_project($_POST);

        echo json_encode([
            "success"    => intval($new_project) > 0 ? 1 : 0,
            "updated_id" => $new_project,
            "action"     => "ProjectController/action=update_project"
        ]);
        exit;

    case 'get_projects':
        echo json_encode([
            "data"       =>  $project_model->get_projects(),
            "success"    => 1,
            "action"     => "ProjectController/action=get_projects"
        ]);
        exit;
        break;

    case 'remove_project':
        echo json_encode([
            "data"       =>  $project_model->remove_project($_GET['id']),
            "success"    => 1,
            "action"     => "ProjectController/action=get_projects"
        ]);
        exit;
        break;
    
    default:
        # code...
        break;
}