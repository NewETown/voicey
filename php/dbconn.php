<?php

class DBConnection {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "voiceytest";
    
    public function GetConnection() {
        try
        {
            $dbconn = new PDO('mysql:host='.$this->hostname.';dbname='.$this->database.';charset=UTF8', $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbconn;

            } catch (PDOException $e) {
                error_log("Failed to connect to database. " . $e->getMessage(), 0);
                return false;
            }
        }
    
    }

?>