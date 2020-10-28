<?php

class Education {
    private $conn;

    public $edu_school;
    public $edu_name;
    public $edu_start;
    public $edu_stop;

    //_construct(db) - lagrar anslutning till databasen i klassens property "conn"
    public function __construct($db) {
        $this->conn = $db;
    }


    public function readEdu() {
        $sql = "SELECT * FROM elku1901.education ORDER by edu_stop DESC";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    }
    
    
    function readOneEdu($id) {
        $sql = "SELECT * FROM elku1901.education WHERE id=$id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function create($edu_school, $edu_name, $edu_start, $edu_stop) {
        //control if correct values
        if(!$this->setCourse($edu_school, $edu_name, $edu_start, $edu_stop)) { 
            //$messageEdu = '<p class="message">Du har inte fyllt i alla fält</p>';
            //return $messageEdu; 
            return false; 
        }

        $sql = "INSERT INTO elku1901.education             
            SET 
                edu_school = ?, edu_name = ?, edu_start = ?, edu_stop = ?";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute([$this->edu_school, $this->edu_name, $this->edu_start, $this->edu_stop])) {
            return true;
        } else {
            
            return false;
        }
        
    }

    function updateEdu($id, $edu_school, $edu_name, $edu_start, $edu_stop) {
        $sql = "UPDATE elku1901.education
            SET 
                edu_school = ?, edu_name = ?, edu_start = ?, edu_stop = ?
                    WHERE id = $id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		if($stmt->execute([$this->edu_school, $this->edu_name, $this->edu_start, $this->edu_stop])){
			return true;
		} else {
			return false;
		}
		
		
    }

    function deleteEdu($id) {
        $sql = "DELETE FROM elku1901.education WHERE id=$id";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    function setCourse($edu_school, $edu_name, $edu_start, $edu_stop) {
        $this->edu_school = strip_tags($edu_school);
        $this->edu_name = strip_tags($edu_name);
        $this->edu_start = strip_tags($edu_start);
        $this->edu_stop = strip_tags($edu_stop);

        
        if($this->edu_name != "") {
            return true;
        } else {
            return false;
        }
    }


}