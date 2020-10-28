<?php 

class Database {
    //database settings
    private $host = DBHOST; 
    private $db_name = DBDATABASE; 
    private $username = DBUSER; 
    private $password = DBPASS; 
    private $conn;
    
    //connect to database
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //error with connection
        } catch(PDOException $e) { 
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }

    public function close() {
        $this->conn = null;
    }






}