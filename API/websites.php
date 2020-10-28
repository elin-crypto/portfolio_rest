<?php

include ('config.php');


//Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, x-Request-With');


$method = $_SERVER['REQUEST_METHOD'];
// if a id parameter exist in url
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}



//connect to database
$database = new Database();
$db = $database->connect();

//instansiate class Courses for sql-queries
//send database-connection as parameter
$websites = new Websites($db);



switch($method) {
    case 'GET':
        if(isset($id)) {
            //function to read row with specific id
            $result = $websites->readOneWebsite($id);
        } else {
            //function to read data from table
            $result = $websites->readWebsite();
            
        }

        //Check if result isn't empty
        if(!$result) {
            http_response_code(404); //not found
            $result = array("message" => "Inga webbplatser hittade");
        } else {
            http_response_code(200); //ok
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        //Remove tags and makes special characters availble to store
        //and send input to the class proterties
        $websites->ws_title = $data->ws_title;
        $websites->ws_url = $data->ws_url;
        $websites->ws_description = $data->ws_description;
        //$websites->ws_image = $data->ws_image;
        

        //Function to create row
        if($websites->create($data->ws_title, $data->ws_url, $data->ws_description/*, $filePath*/)) {
            http_response_code(201); //created
            $result = array("message" => "Webbplats tillagd");
        } else {
            http_response_code(503); //Server error
            $result = array("message" => "Webbplats EJ tillagd");
        }
    break;
    case 'PUT':
        //if no id is sent - send error
        if(!isset($id)) {
            http_response_code(510); //Not extended
            $result = array("message" => "Inget id är skickat");
        } else {
            $data = json_decode(file_get_contents("php://input"));
        }

        //Remove tags and makes special characters availble to store
        //and send input to the class proterties
        $websites->ws_title = $data->ws_title;
        $websites->ws_url = $data->ws_url;
        $websites->ws_description = $data->ws_description;
        //$websites->ws_image = $data->ws_image;

        //run function for update row
        if($websites->updateWebsite($id, $data->ws_title, $data->ws_url, $data->ws_description/*, $data->ws_image*/)) {
            http_response_code(200); //ok
            $result = array("message" => "Webbplatsen är uppdaterad");
        } else {
            http_response_code(503); //server error
            $result = array("message" => "Webbplatsen är inte uppdaterad");
        }
    break;
    case 'DELETE':
        //if no id is sent - send error
        if(!isset($id)) {
            http_response_code(510); //Not extended
            $result = array("message" => "Inget id är skickat");
        } else {
            if($websites->deleteWebsite($id)) {
                http_response_code(200); //ok
                $result = array("message" => "Webbplatsen är raderad");
            } else {
                http_response_code(503); //Server error
                $result = array("message" => "Webbplatsen är inte raderad");
            }
        }
    break;

}



//return result as json
echo json_encode($result, JSON_PRETTY_PRINT);

//close database connection
$db = $database->close();












/* FUNKAR INTE 
 if(isset($_FILES)) {

            $uploadDir = 'http://studenter.miun.se/~elku1901/writeable/projektAdmin/'.'images/'; 
            $fileName = $_FILES["file"]["name"];
            $filePath = $uploadDir . $fileName;
            
            if(move_uploaded_file($_FILES['file']['tmp_name'], "../images/" . $_FILES["file"]["name"])) {
                $data = json_decode(file_get_contents("php://input"));

                //Remove tags and makes special characters availble to store
                //and send input to the class proterties
                $websites->ws_title = $data->ws_title;
                $websites->ws_url = $data->ws_url;
                $websites->ws_description = $data->ws_description;
                //$websites->ws_image = $data->ws_image;
                
        
                //Function to create row
                if($websites->create($data->ws_title, $data->ws_url, $data->ws_description, $filePath)) {
                    http_response_code(201); //created
                    $result = array("message" => "Webbplats tillagd");
                } else {
                    http_response_code(503); //Server error
                    $result = array("message" => "Webbplats EJ tillagd");
                }
          
            } else {
                $result = array("message" => 'File not uploaded');
            }
         
            $result = array("message" => 'en fil uppladdas'. $fileName);
        } else {
            $result = array("message" => 'Det funkar inte' . $fileName);
        } */


