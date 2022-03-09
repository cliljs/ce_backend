<?php

class Helpers {

    public function get_insert_fields($arr)
    {
      return "(" . implode(",", array_keys($arr)) . ")";   
    }

    public function get_update_fields($arr)
    {
      return implode("= ?,", array_keys($arr)) . '= ?'; 
    }

    public function fn_print_die($string)
    {
        echo "<pre>";
        print_r($string);
        echo "</pre>";
        exit;
    }

    public function upload($file_path = null, $file =[]) 
    {
        $uploadDirectory = UPLOAD_PATH .  "/{$file_path}/";
      
        $errors = [];
        $path_parts = pathinfo($file['name']);

        $fileName      = $file['name'];
        $fileSize      = $file['size'];
        $fileTmpName   = $file['tmp_name'];

        $tick = strtotime(date('Y-m-d H:i:s'));

        $uploadPath = $uploadDirectory . $path_parts['filename'].'_'. $tick . '.' . $path_parts['extension']; 
    
        if ($fileSize > 4000000) {
          $errors['has_error'] = 1;
          $errors['msg']       = "File exceeds maximum size (4MB)";

          return $errors;
        }
  
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
          return [
            "filename"       => $path_parts['filename'],
            "file_temp"      => $fileTmpName,
            "filesize"       => $fileSize,
            "created_by"     => $_SESSION['uid'],
            "date_created"   => date('Y-m-d H:i:s'),
            "file_link"      => $uploadPath,
            "timestamp_tick" => $tick,
          ];
        } else {
           return [
             "has_error" => true,
             "msg"       => "Something went wrong on File Upload"
           ];
        }

    }
}

$common = new Helpers();