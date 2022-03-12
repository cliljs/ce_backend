<?php

include_once '../models/TodoModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'create_todo':
        $new_todo =  $todo_model->create_todo($_POST);

        echo json_encode([
            "success"   => $new_todo > 0 ? 1 : 0,
            "insert_id" => $new_todo,
            "action"    => "TodoController/ation=create_todo"
        ]);
        exit;
        break;

    case 'update_todo':
            $update_todo =  $todo_model->update_todo($_POST);
    
            echo json_encode([
                "success"   => intval($update_todo) > 0 ? 1 : 0,
                "update_id" => $update_todo,
                "action"    => "TodoController/ation=update_todo"
            ]);
            exit;
            break;

    case 'get_todods':
        $result =  $todo_model->get_todos($_POST);

        echo json_encode([
            "success"   => 1,
            "data"      => $result,
            "action"    => "TodoController/ation=get_todods"
        ]);
        exit;
        break;
    
    default:
        break;
}