<?php

class Websites {
    private $conn;

    public $ws_title;
    public $ws_url;
    public $ws_description;
    //public $ws_image;

    //_construct(db) - lagrar anslutning till databasen i klassens property "conn"
    public function __construct($db) {
        $this->conn = $db;
    }


    public function readWebsite() {
        $sql = "SELECT * FROM elku1901.websites";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    }
    
    
    function readOneWebsite($id) {
        $sql = "SELECT * FROM elku1901.websites WHERE id=$id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function create($ws_title, $ws_url, $ws_description/*, $ws_image*/) {
        //control if correct values
        if(!$this->setWebsite($ws_title, $ws_url, $ws_description/*, $ws_image*/)) { return false; }


        

        $sql = "INSERT INTO elku1901.websites             
            SET 
                ws_title = ?, ws_url = ?, ws_description = ?/*, ws_image = ?*/";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute([$this->ws_title, $this->ws_url, $this->ws_description/*, $this->ws_image*/])) {
            return true;
        } else {
            return false;
        }
        
    }

    function updateWebsite($id, $ws_title, $ws_url, $ws_description/*, $ws_image*/) {
        $sql = "UPDATE elku1901.websites
            SET 
                ws_title = ?, ws_url = ?, ws_description = ?/*, ws_image = ?*/
                    WHERE id = $id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		if($stmt->execute([$this->ws_title, $this->ws_url, $this->ws_description/*, $this->ws_image*/])){
			return true;
		} else {
			return false;
		}
		
		
    }

    function deleteWebsite($id) {
        $sql = "DELETE FROM elku1901.websites WHERE id=$id";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    function setWebsite($ws_title, $ws_url, $ws_description/*, $ws_image*/) {
        $this->ws_title = strip_tags($ws_title);
        $this->ws_url = strip_tags($ws_url);
        $this->ws_description = strip_tags($ws_description);
        //$this->ws_image = strip_tags($ws_image);
        
        if($this->ws_url != "") {
            return true;
        } else {
            return false;
        }
    }


}
