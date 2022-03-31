<?php 
include_once '../../autoload.php';

class ScheduleModel {

    private $base_table = 'ce_schedule';

    public function create_schedule($payload)
    {
        global $db, $common;

        $arr = [
            "user_id"    => $payload['user_id'],
            "task"       => $payload['task'],
            "date_start" => $payload['date_start'],
            "date_end"   => $payload['date_end'],
            "status"     => $payload['status'],
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?)", array_values($arr));
    }

    public function update_schedule($payload, $pk)
    {
        global $db, $common;

		$update_fields = $common->get_update_fields($payload);

        $payload['id'] = $pk;
		$db->query("UPDATE {$this->base_table} SET {$update_fields} WHERE id = ?", array_values($payload));

        $updated_schedule = $db->select("SELECT * FROM {$this->base_table} WHERE id = ?", [$pk]);

		return !empty($updated_schedule) ? $updated_schedule[0] : [];
    }

    // GET SCHEDULES BY MONTH
    public function get_schedules($params)
    {
        global $db, $common;

        $result = $db->select("SELECT * FROM 
                               {$this->base_table} 
                               WHERE user_id = ? 
                               ORDER BY date_start ASC",
                               array_values($params));

		return $result;
    }

    // GET SCHEDULES BY MONTH
    public function remove_schedule($pk)
    {
        global $db, $common;
        $db->query("DELETE FROM {$this->base_table} WHERE id = ?", [$pk]);
        return true;
    }
}

$schedule_model = new ScheduleModel();