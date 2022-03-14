<?php 

include_once '../../autoload.php';

class NoteModel {
    private $base_table = 'ce_notes';

    public function create($payload = []) 
    {
        global $db, $common;

        $arr = [
            "title"        => $payload['title'],
            "content"      => $payload['content'],
            "date_created" => date('Y-m-d H:i:s'),
            "author_id"    => $payload['user_id'],
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?)", array_values($arr));
    }

    public function update($payload = []) 
    {
        global $db, $common;

        $note_pk                 = $payload['note_id'];
        $payload['date_updated'] = date('Y-m-d H:i:s');
        
        unset($payload['note_id']);
        $update_fields = $common->get_update_fields($payload);
      
        $payload['note_id'] = $note_pk;
        $db->query("UPDATE {$this->base_table} SET {$update_fields} WHERE id = ?", array_values($payload));

        return $note_pk;
    }

    public function get_user_note($payload = []) 
    {
        global $db, $common;

        return $db->select("SELECT * FROM {$this->base_table} WHERE author_id = ?", [$payload['user_id']]);
    }

    public function remove_note($id = null) 
    {
        global $db, $common;

        $db->query("DELETE FROM {$this->base_table} WHERE id = ?", [$id]);

        return $id;
    }
}

$note_model = new NoteModel();