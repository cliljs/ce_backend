<?php

include_once '../../autoload.php';
/* 
    NAGEEXPIRE PALA TOKEN NA GALING EMAIL KUYA

    * mga kulang
     - DI MUNA AKO NAGLAGAY NG UPDATE KASI GALING SA GOOGLE YUNG DATA NILA
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

        $_SESSION['uid']       = $has_account[0]['id'];
        $_SESSION['email']     = $has_account[0]['email'];
        $_SESSION['firstname'] = $has_account[0]['firstname'];
        $_SESSION['lastname']  = $has_account[0]['lastname'];

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

    public function profile_update($payload= [])
    {
        global $db, $common;

		$accounts_pk = null;
		if (!empty($_SESSION)) {
			$accounts_pk = $_SESSION["uid"];
		} else {
			$accounts_pk = $payload['account_id'];
		}

        if (array_key_exists('account_id', $payload)) {
            unset($payload['account_id']);
        }
		
		$update_fields = $common->get_update_fields($payload);

		$payload['account_id'] = $accounts_pk;
		$db->query("UPDATE {$this->base_table} SET {$update_fields} WHERE id = ?", array_values($payload));

		$account = $db->select("SELECT *  FROM {$this->base_table}  WHERE id = ?", [$payload['account_id']]);

		return $account[0];
        
    }
}

$account_model = new AccountModel();