<?php 

class Database {
    //database settings
    private $host = 'studentmysql.miun.se'; //localhost;8080
    private $db_name = 'elku1901'; //elin_cv
    private $username = 'elku1901'; //elin_cv
    private $password = 'fkdd7cpm'; //elin_cv
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