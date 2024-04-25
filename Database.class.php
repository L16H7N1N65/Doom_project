<?php 

class Database extends PDO {
    private $_DB_HOST = 'localhost';
    private $_DB_USER = 'root';
    private $_DB_PASS = 'root';
    private $_DB_NAME = 'fpview';

    public function __construct() {
        try {
            error_log("Connecting to database");
        parent::__construct("mysql:host=".$this->_DB_HOST.";dbname=".$this->_DB_NAME, $this->_DB_USER, $this->_DB_PASS);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}


