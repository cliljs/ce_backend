<?php

include_once '../../autoload.php';

class ComputeModel {

    private $base_table = "ce_compute";
    private $values_table = "ce_worksettings";

    public function create_compute($payload = [])
    {
        global $db, $common;
   
        $arr  = [
            "project_id"      => $payload['project_id'],
            "category"        => $payload['category'],
            "sub_category"    => $payload['sub_category'],
            "cat_key"         => $payload['area'],
            "value"           => $payload['preferred_time'],
            "optional_param"  => @$payload['optional_param'] ? $payload['optional_param'] : null,
            "worker1_count"   => $payload['worker1_count'],
            "worker2_count"   => $payload['worker2_count'],
            "work_days"       => $payload['work_days']
        ];

        $is_exists = $db->select("SELECT * FROM 
                                 {$this->base_table} 
                                 WHERE category = ? AND sub_category = ? AND project_id = ?", 
                                 [$arr['category'], $arr['sub_category'], $arr['project_id']]);

        if (empty($is_exists)) {
            $fields = $common->get_insert_fields($arr);

            return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?,?,?,?)", array_values($arr));
        } else {
            $compute_row = $is_exists[0];

            $fields = $common->get_update_fields($arr);
    
            $arr['id'] = $compute_row['id'];
            $db->query("UPDATE {$this->base_table} SET {$fields} WHERE id = ?", array_values($arr));
    
            return $compute_row['id'];
        }
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

    // WHERE project_id = ?
    public function get_compute_projects($project_params = [])
    {
        global $db, $common;
        
        return $db->select("SELECT * FROM {$this->base_table} WHERE project_id = ? AND user_id = ?", array_values($project_params));
    }

    // WHERE project_id = ?, category = ?
    public function get_compute_by_cat($get = [])
    {
        global $db, $common;
        
        return $db->select("SELECT * FROM {$this->base_table} 
                            WHERE project_id = ? AND category = ? AND user_id = ?", 
                            array_values($get));
    }

    // WHERE project_id = ?, category = ?, sub_cat = ?
    public function get_compute_all($get = [])
    {
        global $db, $common;
        
        return $db->select("SELECT * FROM {$this->base_table} 
                            WHERE project_id = ? AND category = ? AND sub_category = ? AND user_id = ?", 
                            array_values($get));
    }

    public function get_default_values($params)
    {
        global $db, $common;
        
        return $db->select("SELECT * FROM {$this->values_table} WHERE user_id = ?", array_values($params));
    }
}

$compute_model = new ComputeModel();