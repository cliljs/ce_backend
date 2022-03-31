<?php
include_once '../models/ScheduleModel.php';

$act = !empty($_GET['action']) ? $_GET['action'] : '';

switch ($act) {
    case 'create_schedule':
        echo json_encode([
            "data"      => $schedule_model->create_schedule($_POST),
            "success"   => 1,
            "action"    => "ScheduleController/?action=create_schedule"
        ]);
        break;

    case 'update_schedule':
        echo json_encode([
            "data"      => $schedule_model->update_schedule($_POST, $_GET['pk']),
            "success"   => 1,
            "action"    => "ScheduleController/?action=update_schedule"
        ]);
        break;
    
    case 'get_schedules':
        unset($_GET['action']);
        echo json_encode([
            "data"      => $schedule_model->get_schedules($_GET),
            "success"   => 1,
            "action"    => "ScheduleController/?action=get_schedules"
        ]);
        break;

    case 'remove_schedule':
        echo json_encode([
            "data"      => $schedule_model->remove_schedule($_GET['pk']),
            "success"   => 1,
            "action"    => "ScheduleController/?action=remove_schedule"
        ]);
        break;

    default:
        break;
}