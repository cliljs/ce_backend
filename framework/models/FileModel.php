<?php 

include_once '../../autoload.php';

class FileModel {

    private $base_table = "ce_files";

    public function create($file) 
    {
        global $db, $common;

        $file_data = $common->upload_new('files', $file);
        
        $fields = null;
        if (array_key_exists("has_errors", $file_data)) {
            return $file_data;
        } else {
             $fields = $common->get_insert_fields($file_data);
        }

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?)", array_values($file_data));
    }

    public function update($id, $file)
    {
        global $db, $common;
       
        $file_row = $db->select("SELECT * FROM {$this->base_table} WHERE id = ?", [$id]);

        unlink($file_row[0]['file_link']);

        $file_data = $common->upload_new('files', $file);
        
        $fields = null;
        if (array_key_exists("has_errors", $file_data)) {
            return $file_data;
        } else {
             $fields = $common->get_update_fields($file_data);
        }

        $file_data['id'] = $id;
        $db->query("UPDATE {$this->base_table} SET {$fields} WHERE id = ?", array_values($file_data));

        return $id;
    }

    public function get_user_files() 
    {
        global $db, $common;

        return $db->select("SELECT cfe.*, cea.firstname, cea.lastname FROM {$this->base_table} cfe
                            INNER JOIN ce_accounts cea ON cfe.created_by = cea.id
                            ", []);
    }

    public function remove_file($id)
    {
        global $db, $common;

        $file_data = $db->select("SELECT * FROM {$this->base_table} WHERE id = ?", [$id]);
        unlink(UPLOAD_PATH . $file_data[0]['file_link']);

        $db->query("DELETE FROM {$this->base_table} WHERE id = ?", [$id]);

        return $id;
    }
}

$file_model = new FileModel();