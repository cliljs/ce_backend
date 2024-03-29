<?php

include_once '../models/NoteModel.php';
include_once '../../autoload.php';

$act = isset($_GET['action']) ? $_GET['action'] : '';


switch ($act) {
    case 'note_create':
        $result = $note_model->create($_POST);

        echo json_encode([
            "success" => 1,
            "data"    => $result,
            "action"  => 'NoteController.php/?action=note_create'
        ]);
        exit;
        break;

    case 'note_update':
        $result = $note_model->update($_POST);

        echo json_encode([
            "success" => 1,
            "data"    => $result,
            "action"  => 'NoteController.php/?action=note_update'
        ]);
        exit;
        break;

    case 'get_notes':
        echo json_encode([
            "success" => 1,
            "data"    => $note_model->get_user_note($_POST),
            "action"  => 'NoteController.php/?action=get_notes'
        ]);
        exit;
        break;
    
    case 'remove_note':
        echo json_encode([
            "success" => 1,
            "data"    => $note_model->remove_note($_GET['id']),
            "action"  => 'NoteController.php/?action=remove_note'
        ]);
        exit;
        break;
    
    default:
        # code...
        break;
}