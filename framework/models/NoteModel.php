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
            "author_id"    => $_SESSION['uid'],
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?)", array_values($arr));
    }

    public function update($payload) 
    {
        global $db, $common;

        $note_pk = $payload['note_id'];

        unset($payload['note_id']);
        $update_fields = $common->get_update_fields($payload);
      
        $payload['note_id'] = $note_pk;
        $db->query("UPDATE {$this->base_table} SET {$update_fields} WHERE id = ?", array_values($payload));

        return $note_pk;
    }
}

$note_model = new NoteModel();