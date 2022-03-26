<?php
include_once '../../autoload.php';

class LaborModel {
    private $base_table = 'ce_labor';

    public function create_labor($payload)
    {
        global $db, $common;

        $arr = [
            "job_title"  => trim($payload['job_title']),
            "job_salary" => $payload['job_salary'],
            "created_at" =>  date('Y-m-d H:i:s')
        ];

        $fields = $common->get_insert_fields($arr);

        $is_exist = $db->select("SELECT * FROM {$this->base_table} WHERE job_title = ?", [$arr['job_title']]);

        if (!empty($is_exist)) {
            return true;
        }

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?)", array_values($arr));
    }

    public function update_labor($payload, $id)
    {
        global $db, $common;

        $fields = $common->get_update_fields($payload);

        if (array_key_exists('job_title', $payload)) {
            $is_exist = $db->select("SELECT * FROM {$this->base_table} WHERE job_title = ?", [$payload['job_title']]);

            if (!empty($is_exist)) {
                return true;
            }
        }

        $payload['id'] = $id;
        $db->query("UPDATE {$this->base_table} SET {$fields} WHERE id = ?", array_values($payload));

        return intval($id);
    }

    public function get_labors()
    {
        global $db, $common;

        return $db->select("SELECT * FROM {$this->base_table}");
    }
}

$labor_model = new LaborModel();