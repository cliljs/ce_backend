<?php

include_once '../../autoload.php';
/* 
    NAGEEXPIRE PALA TOKEN NA GALING EMAIL KUYA

    * mga kulang
     - DI MUNA AKO NAGLAGAY NG UPDATE KASI GALING SA GOOGLE YUNG DATA NILA
*/

class AccountModel {
    private $base_table = "ce_accounts";
    private $mobile_dev = 'barata.bryannikko@gmail.com';
    public function login($payload = []) 
    {
        global $db, $common;

        $request_email = array_key_exists('email', $payload) ? $payload['email'] : '';

        $has_account = $db->select("SELECT * FROM {$this->base_table} WHERE email = ?", [$request_email]);

        if (empty($has_account)) {
            return ['exists' => true];
        }

        return $has_account[0];
    }
    public function account_get($payload = []) 
    {
        global $db, $common;
        $user_id = $payload['user_id'];
        $has_account = $db->select("SELECT * FROM {$this->base_table} WHERE id = ?", [$user_id]);
        return $has_account[0];
    }
    public function profile_create($payload = []) 
    {
        global $db, $common;

        $arr = [
            "email"              => $payload['email'],
            "firstname"          => $payload['firstname'],
            "lastname"           => $payload['lastname'],
            "gender"             => $payload['gender'],
            "contact_number"     => $payload['contact_number'],
            "job_position"       => $payload['job_position'],
            "verification_token" => $payload['verification_token'],
            "date_created"       => date('Y-m-d H:i:s'),
            "employee_id"        => $payload['employee_id'],
            "work_exp"        => $payload['work_exp']
        ];

        $has_account = $db->select("SELECT * FROM {$this->base_table} WHERE email = ?", [$payload['email']]);
        if (!empty($has_account)) {
            return ['exists' => true];
        }
        $fields = $common->get_insert_fields($arr);    
        $autoID = $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?,?,?,?,?)", array_values($arr));

        return $autoID;
    }

    public function profile_update($payload= [])
    {
        global $db, $common;

        $accounts_pk = $payload['account_id'];

        if (array_key_exists('account_id', $payload)) {
            unset($payload['account_id']);
        }
		
		$update_fields = $common->get_update_fields($payload);

		$payload['account_id'] = $accounts_pk;
		$db->query("UPDATE {$this->base_table} SET {$update_fields} WHERE id = ?", array_values($payload));

		$account = $db->select("SELECT *  FROM {$this->base_table}  WHERE id = ?", [$payload['account_id']]);

		return $account[0];
        
    }

    
    public function profile_delete($payload= [])
    {
        global $db, $common;
        $pk = $payload['account_id'];
		return $db->query("DELETE from {$this->base_table} WHERE {$this->base_table}.id = ?",[$pk]);
    }

    // TO BE UPDATED TO CE_LABOR
    public function get_job_positions()
    {
        global $db, $common;
        return $db->select("SELECT job_position FROM {$this->base_table} GROUP BY job_position ORDER BY job_position", []);
    }

    public function get_account_list($user_id)
    {
        global $db, $common;
        return $db->select("SELECT * FROM {$this->base_table} 
                            WHERE NOT id = ? AND ((firstname <> ? OR firstname <> ?) AND lastname <> ?)
                             AND  email <>  ?", 
                            [$user_id, 'bryan', 'bryan nikko', 'barata', $this->mobile_dev]);
    }
}

$account_model = new AccountModel();