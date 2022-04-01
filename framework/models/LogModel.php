<?php 
include_once '../../autoload.php';
include_once '../controllers/MailController.php';
class LogModel {
    private $base_table = 'ce_logs';

    public function create_log($payload = []) 
    {
        global $db, $common, $mail_controller;
        
        $emp_file = [
            "file_name" => $payload['emp_filename'],
            "file_temp" => $payload['emp_base64'],
            "ext"       => $payload['emp_file_ext'],
            "user_id"   => $payload['user_id'],
        ];  
        $emp_signature        = $common->upload_new('images', $emp_file);

        $adv_file = [
            "file_name" => $payload['adv_filename'],
            "file_temp" => $payload['adv_base64'],
            "ext"       => $payload['adv_file_ext'],
            "user_id"   => $payload['user_id'],
        ];  
        $supervisor_signature = $common->upload_new('images', $adv_file);

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
            "email"                => $payload['email'], 
            "user_id"                => $payload['user_id'], 
        ];

        $fields = $common->get_insert_fields($arr);

        $new_log = $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?,?,?,?,?,?,?)", array_values($arr));
        
        $recent_log = $db->select("SELECT lg.*, pr.name AS 'project_name' FROM 
                                   {$this->base_table} lg 
                                   INNER JOIN ce_projects pr 
                                   WHERE lg.id = ?", [$new_log]);

        $recent_log = !empty($recent_log) ? $recent_log[0] : [];

        return $mail_controller->send_email_logs($recent_log);
    }

    public function get_logs($type = 1, $user_id) 
    {
        global $db, $common;

        $is_daily_logs = $type === 1 ? 1 : 0;

        return $db->select("SELECT *
                            FROM {$this->base_table} 
                            WHERE is_daily_log = ? AND user_id = ?", 
                            [$is_daily_logs, $user_id]);
    }

    public function get_log_row($pk) 
    {
        global $db, $common;

        $result =  $db->select("SELECT * FROM {$this->base_table} WHERE id = ?", [ $pk ]);

        return $result[0];
    }

}

$log_model = new LogModel();