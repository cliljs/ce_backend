<?php 

class LogModel {
    private $base_table = 'ce_logs';

    public function create_log($payload = [], $files = []) 
    {
        global $db, $common;
        
        $emp_signature        = $common->upload('images', $files[0]);
        $supervisor_signature = $common->upload('images', $files[1]);

        $arr = [
            "name"                 => $payload['name'],
            "time_in"              => $payload['time_in'], 
            "time_out"             => $payload['time_out'], 
            "log_date"             => date('Y-m-d'), 
            "project"              => $payload['project'], 
            "tasks"                => $payload['tasks'], 
            "emp_signature"        => $emp_signature['file_link'], 
            "supervisor_signature" => $supervisor_signature['file_link'], 
            "email_to"             => $payload['email_to'], 
            "is_daily_log"         => $payload['is_daily_log'], 
            "email"                => $_SESSION['email'], 
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?,?,?,?,?,?)", array_values($arr));
    }

    // 
    public function get_logs($type = 1) 
    {
        global $db, $common;

        $is_daily_logs = $type === 1 ? 1 : 0;

        return $db->select("SELECT * FROM {$this->base_table} WHERE email = ? AND is_daily_log = ?", [ $_SESSION['email'], $is_daily_logs ]);
    }

}

$log_model = new LogModel();