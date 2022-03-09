<?php

include_once '../models/FileModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'file_upload':
        $new_file =  $file_model->create($_FILES['form_data']);

        $res = ["action" => "FileController.php/?action=file_upload"];
        if (is_array($new_file)) {
            $res['success'] = 0;
            $res['msg']     = $new_file['msg'];
        } else {
            $res['success'] = 1;
            $res['msg']     = "Successfully Created";
        }

        echo json_encode($res);
        exit;
        break;

    case 'file_update':
        $new_file =  $file_model->update($_POST['id'], $_FILES['form_data']);

        $res = ["action" => "FileController.php/?action=file_update"];
        if (is_array($new_file)) {
            $res['success'] = 0;
            $res['msg']     = $new_file['msg'];
        } else {
            $res['success'] = 1;
            $res['msg']     = "Successfully Created";
        }

        echo json_encode($res);
        exit;
        break;

    case 'get_files':
        echo json_encode([
            "success" => 1,
            "data"    => $file_model->get_user_files(),
            "action"  => "FileController.php/?action=get_files"
        ]);
        exit;
        break;
    
        // DELETE ROUTE
    
    default:
        # code...
        break;
}

