<?php

include_once './autoload.php';



$act = !empty($_GET['act']) ? $_GET['act'] : ''; 

switch ($act) {
    case 'seed':
            $test_data = [
                "email"              => "calilchristopher052997@gmail.com",
                "firstname"          => "Calil",
                "lastname"           => "Jaudian",
                "gender"             => "M",
                "contact_number"     => "09955591932",
                "verification_token" => "qweqweqjqkeqkjeqwnkeqkqewqwehj",
                "date_created"       => date('Y-m-d H:i:s')
            ];

            $dummy = $db->select("SELECT * FROM ce_accounts WHERE email = ? ", [$test_data['email']]);

            if (!empty($dummy)) {
                echo "Exists";
            } else {
                $insert_fields = $common->get_insert_fields($test_data);

             echo $db->query("INSERT INTO ce_accounts {$insert_fields} VALUES (?,?,?,?,?,?,?)", array_values($test_data));
            }
        break;
    
    case 'truncate': 
        $db->query("TRUNCATE TABLE ce_accounts", []);
        echo "TRUNCATE ce_accounts <br />";

        $db->query("TRUNCATE TABLE ce_files", []);
        echo "TRUNCATE ce_files <br />";

        $db->query("TRUNCATE TABLE ce_logs", []);
        echo "TRUNCATE ce_logs <br />";

        $db->query("TRUNCATE TABLE ce_notes", []);
        echo "TRUNCATE ce_notes <br />";
    break;

        break;

    default:
        # code...
        break;
}