<?php

include_once '../../autoload.php';

class ProjectModel {

    private $base_table = 'ce_projects';

    public function create_project($payload = [])
    {
        global $db, $common;

        $arr = [
            "name"         => $payload['name'],
            "description"  => $payload['description'],
            "type"         => $payload['type'],
            "created_by"   => $payload['created_by'],
            "date_created" => date('Y-m-d H:i:s'),
            "sq_meters"    => $payload['sq_meters'],
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?)", array_values($arr));
    }

    public function update_project($payload = [])
    {
        global $db, $common;

        $project_pk = $payload['project_id'];

        unset($payload['project_id']);
        $fields = $common->get_update_fields($payload);

        $payload['project_id'] = $project_pk;
        $db->query("UPDATE {$this->base_table} SET {$fields} WHERE id = ?", array_values($payload));

        return $project_pk;
    }
    
    public function get_projects() 
    {
        global $db, $common;

        return $db->select("SELECT * FROM {$this->base_table}", []);
    }

}

$project_model = new ProjectModel();
