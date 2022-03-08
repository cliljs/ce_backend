<?php

include_once '../../autoload.php';
/* 
    NAGEEXPIRE PALA TOKEN NA GALING EMAIL KUYA
*/

class AccountModel {
    private $base_table = "ce_accounts";

    public function login($payload = []) 
    {
        global $db, $common;

        $request_email = array_key_exists('email', $payload) ? $payload['email'] : '';

        $has_account = $db->select("SELECT * FROM {$this->base_table} WHERE email = ?", [$request_email]);

        if (empty($has_account)) {
            return ['exists' => false];
        }

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
            "verification_token" => $payload['token'],
            "date_created"       => date('Y-m-d H:i:s')
        ];

        $fields = $common->get_insert_fields($arr);

        return $db->query("INSERT INTO {$this->base_table} {$fields} VALUES (?,?,?,?,?,?,?)", array_values($arr));
    }
}

$account_model = new AccountModel();