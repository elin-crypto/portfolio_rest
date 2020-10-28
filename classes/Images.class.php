<?php

class Images {
    private $conn;

    public $storedfile;
    public $ws_title;

    //_construct(db) - lagrar anslutning till databasen i klassens property "conn"
    public function __construct($db) {
        $this->conn = $db;
    }


    public function readImages() {
        $sql = "SELECT * FROM elku1901.images";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    }
    
    
    function readOneImage($id) {
        $sql = "SELECT * FROM elku1901.images WHERE id=$id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function createImage($storedfile, $ws_title) {
        //control if correct values
        if(!$this->setImage($storedfile, $ws_title)) { 
            return false; 
        }

        $sql = "INSERT INTO elku1901.images             
            SET 
                fileName = ?, ws_title = ?";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute([$this->storedfile, $this->ws_title])) {
            return true;
        } else {
            
            return false;
        }
        
    }

    function updateImage($id, $storedfile, $ws_title) {
        $sql = "UPDATE elku1901.images
            SET 
                fileName = ?, ws_title = ?
                    WHERE id = $id";

        // Prepare and execute statement
		$stmt = $this->conn->prepare($sql);
		if($stmt->execute([$this->storedfile, $this->ws_title])){
			return true;
		} else {
			return false;
		}
		
		
    }

    function deleteImage($id) {
        $sql = "DELETE FROM elku1901.images WHERE id=$id";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    function setImage($storedfile, $ws_title) {
        $this->storedfile = strip_tags($storedfile);
        $this->ws_title = strip_tags($ws_title);
        
        if($this->storedfile != "") {
            return true;
        } else {
            return false;
        }
    }


}