<?php

class Work {
    private $conn;

    public $work_place;
    public $work_title;
    public $work_start;
    public $work_stop;
    public $work_city;

    //_construct(db) - lagrar anslutning till databasen i klassens property "conn"
    public function __construct($db) {
        $this->conn = $db;
    }

    public function readWork() {
        $sql = "SELECT * FROM elku1901.work ORDER by work_stop DESC";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    }
    
    
    function readOneWork($id) {
        $sql = "SELECT * FROM elku1901.work WHERE id=$id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function create($work_place, $work_title, $work_start, $work_stop, $work_city) {
        //control if correct values
        if(!$this->setWork($work_place, $work_title, $work_start, $work_stop, $work_city)) { return false; }

        $sql = "INSERT INTO elku1901.work             
            SET 
                work_place = ?, work_title = ?, work_start = ?, work_stop = ?, work_city = ?";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute([$this->work_place, $this->work_title, $this->work_start, $this->work_stop, $this->work_city])) {
            return true;
        } else {
            return false;
        }
        
    }

    function updateWork($id, $work_place, $work_title, $work_start, $work_stop, $work_city) {
        $sql = "UPDATE elku1901.work
            SET 
                work_place = ?, work_title = ?, work_start = ?, work_stop = ?, work_city = ?
                    WHERE id = $id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		if($stmt->execute([$this->work_place, $this->work_title, $this->work_start, $this->work_stop, $this->work_city])){
			return true;
		} else {
			return false;
		}
		
		
    }

    function deleteWork($id) {
        $sql = "DELETE FROM elku1901.work WHERE id=$id";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    function setWork($work_place, $work_title, $work_start, $work_stop, $work_city) {
        $this->work_place = strip_tags($work_place);
        $this->work_title = strip_tags($work_title);
        $this->work_start = strip_tags($work_start);
        $this->work_stop = strip_tags($work_stop);
        $this->work_city = strip_tags($work_city);

        
        if($this->work_place != "") {
            return true;
        } else {
            return false;
        }
    }


}