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
}

$common = new Helpers();