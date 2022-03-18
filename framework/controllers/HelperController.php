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

    // FOR $_FILES UPLOAD
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

    // FOR BASE 64 UPLOADS
    public function upload_new($upload_type = null, $file = [])
    {
      $decoded_base64 = base64_decode($file['file_temp']);
      $tick           = strtotime(date('Y-m-d H:i:s'));
      $file_name      = null;
      $original_path  = null;

      if ($upload_type === 'files') {
        $file_name     = "files/{$file['file_name']}_{$tick}.{$file['ext']}";
        $original_path = UPLOAD_PATH . $file_name;
      } else {
        $file_name     = "/images/{$file['file_name']}_{$tick}.{$file['ext']}";
        $original_path = UPLOAD_PATH . $file_name;
      }

      $file_size     = file_put_contents($original_path, $decoded_base64);

      return [
        "filename"       => $file_name,
        "filesize"       => $file_size,
        "created_by"     => $file['user_id'],
        "date_created"   => date('Y-m-d H:i:s'),
        "file_link"      => $file_name,
        "timestamp_tick" => $tick,
      ];
    }
}

$common = new Helpers();