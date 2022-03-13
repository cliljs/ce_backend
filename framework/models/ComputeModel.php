<?php

include_once '../../autoload.php';

class ComputeModel {

    private $base_table = "ce_compute";

    public function create_compute($payload = [])
    {
        global $db, $common;

        $arr  = [
            "project_id"   => $payload['project_id'],
            "category"     => $payload['category'],
            "sub_category" => $payload['sub_category'],
            "cat_key"      => $payload['cat_key'],
            "value"        => $payload['value'],
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?)", array_values($arr));
    }
    
    public function update_compute($payload = [])
    {
        global $db, $common;

        $compute_pk = $payload['compute_id'];

        unset($payload['compute_id']);
        $fields = $common->get_update_fields($payload);

        $payload['project_id'] = $compute_pk;
        $db->query("UPDATE {$this->base_table} SET {$fields} WHERE id = ?", array_values($payload));

        return $compute_pk;
    }

    public function get_compute_list($get = [])
    {
        global $db, $common;
        
        unset($get['action']);
        return $db->select("SELECT * FROM {$this->base_table} WHERE project_id = ? AND category = ?", array_values($get));
    }
}

$compute_model = new ComputeModel();