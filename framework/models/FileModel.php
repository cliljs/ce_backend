<?php 

include_once '../../autoload.php';

class FileModel {

    private $base_table = "ce_files";

    public function create($file) 
    {
        global $db, $common;

        $file_data = $common->upload('files', $file);
        
        $fields = null;
        if (array_key_exists("has_errors", $file_data)) {
            return $file_data;
        } else {
             $fields = $common->get_insert_fields($file_data);
        }

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?,?)", array_values($file_data));
    }
}

$file_model = new FileModel();