<?php
include_once "../models/LaborModel.php";

$act = !empty($_GET['action']) ? $_GET['action'] : "";

switch ($act) {
    case 'labor_add':
        $new_labor = $labor_model->create_labor($_POST);

        $res =[
            "success" => 0,
            "action"  => "LaborController.php/action=labor_add"
        ]; 

        if (gettype($new_labor) == 'boolean' && isset($new_labor)) {
            $res['msg']     = "Job position already exists";
        }

        if (gettype($new_labor) == 'integer' && $new_labor > 0) {
            $res['success'] = 1;
        }

        echo json_encode($res);
        break;

    case 'labor_update':
        $updated_labor = $labor_model->update_labor($_POST, $_GET['id']);

        $res =[
            "success" => 0,
            "action"  => "LaborController.php/action=labor_update"
        ]; 

        if (gettype($updated_labor) == 'boolean' && isset($updated_labor)) {
            $res['msg']     = "Job position already exists";
        }

        if (gettype($updated_labor) == 'integer' && $updated_labor > 0) {
            $res['success'] = 1;
        }

        echo json_encode($res);
        break;
        
    case "labor_list":
        echo json_encode([
            "success" => 1,
            "data"    => $labor_model->get_labors(),
            "action"  => "LaborController.php/action=labor_list"
        ]);
        break;

    default:
        break;
    
}