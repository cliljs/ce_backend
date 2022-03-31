<?php

class DatabaseController
{

    private $conn = null;
    public function __construct(
        $host    = "127.0.0.1",
        $db_name = "ce_api_260322",
        $user    = "root",
        $pass    = ""
    ) {
        try {
            $this->conn = new mysqli($host, $user, $pass, $db_name);

            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // execute statement
    private function execute($query = "", $params = [])
    {
        try {
       
            $stmt = $this->conn->prepare($query);

            if ($stmt === false) {
                throw new Exception("Unable to do prepared statement: " . $query);
            }

            if ($params) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Insert a row/s in a Database Table
    public function query($query = "", $params = [])
    {
        try {

            $stmt = $this->execute($query, $params);
            $stmt->close();

            return $this->conn->insert_id;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return false;
    }

    // Select a row/s in a Database Table
    public function select($query = "", $params = [])
    {
        try {
           
            $stmt = $this->execute($query, $params);

            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return false;
    }
}



