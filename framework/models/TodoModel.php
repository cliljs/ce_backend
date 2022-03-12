<?php 

// PANSAMANTALANG SCHEMA DI KO MAKITA YUNG SCHEMA SA OFFICE
// WILL EDIT MAMAYA IF EVER
// PANSAMANTALA YUNG SESSION NASA POST MUNA HAHA

include_once '../../autoload.php';

class TodoModel {

    private $base_table = 'ce_todo';

    public function create_todo($payload = [])
    {
        global $db, $common;

        $arr = [
            "title"        => $payload['title'],
            "description"  => $payload['description'],
            "author_id"    => $payload['user_id'],
            "date_created" => date('Y-m-d H:i:s')
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?)", array_values($arr));
    }

    public function update_todo($payload = [])
    {
        global $db, $common;

        $todo_pk = $payload['todo_id'];

        unset($payload['todo_id']);
        $payload['date_updated'] = date('Y-m-d H:i:s');
        $fields = $common->get_update_fields($payload);

        $payload['todo_id'] = $todo_pk;
        $db->query("UPDATE {$this->base_table} SET {$fields} WHERE id = ?", array_values($payload));

        return $todo_pk;
    }
    
    public function get_todos($payload = [])
    {
        global $db, $common;

        return $db->select("SELECT * FROM {$this->base_table} WHERE author_id = ?", array_column($payload, 'user_id'));
    }
}

$todo_model = new TodoModel();
