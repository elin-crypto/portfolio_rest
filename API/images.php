<?php


include ('../classes/Database.class.php');
include ('../classes/Images.class.php');

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
$images = new Images($db);



switch($method) {
    case 'GET':
        if(isset($id)) {
            //function to read row with specific id
            $result = $images->readOneImage($id);
        } else {
            //function to read data from table
            $result = $images->readImages();
            
        }

        //Check if result isn't empty
        if(!$result) {
            http_response_code(404); //not found
            $result = array("message" => "Inga kurser hittade");
        } else {
            http_response_code(200); //ok
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

                // check if image is correct type and size

        if(count($_FILES['file']) > 0) {
            $target_dir = "../images/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $uploadOk = 0;
                echo "Felmeddelande: Endast JPG, JPEG och PNG är tillåtet.";
            } else {
                //check that image hasn't same name as other file
                if (file_exists("../images/" . $_FILES['file']['name'])) {
                    echo $_FILES['file']['name'] . " finns redan". " Välj ett annat filnamn.";
                } else {
                    //move image to right folder
                    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

                    //Save name original file
                    $storedfile = $_FILES['file']['name'];
                    return $storedfile;
                }
            }
        }

        //Remove tags and makes special characters availble to store
        //and send input to the class proterties
        $images->ws_title = $data->ws_title;
        $images->storedfile = $data->storedfile;

        //Function to create row
        if($images->createImage($storedfile, $data->ws_title)) {
            http_response_code(201); //created
            $result = array("message" => "Bild tillagd");
        } else {
            http_response_code(503); //Server error
            $result = array("message" => "Bild EJ tillagd");
        }
    break;
    case 'PUT':
        //if no id is sent - send error
        if(!isset($id)) {
            http_response_code(510); //Not extended
            $result = array("message" => "No id is sent");
        } else {
            $data = json_decode(file_get_contents("php://input"));
        }
        
        //Remove tags and makes special characters availble to store
        //and send input to the class proterties
        $images->ws_title = $data->ws_title;

        //run function for update row
        if($images->updateImage($id, $storedfile, $data->ws_title)) {
            http_response_code(200); //ok
            $result = array("message" => "Bilden är uppdaterad");
        } else {
            http_response_code(503); //server error
            $result = array("message" => "Bilden är inte uppdaterad");
        }
    break;
    case 'DELETE':
        //if no id is sent - send error
        if(!isset($id)) {
            http_response_code(510); //Not extended
            $result = array("message" => "Inget id är skickat");
        } else {
            if($education->deleteEdu($id)) {
                http_response_code(200); //ok
                $result = array("message" => "Bilden är raderad");
            } else {
                http_response_code(503); //Server error
                $result = array("message" => "Bilden är inte raderad");
            }
        }
    break;

}

//return result as json
echo json_encode($result);

//close database connection
$db = $database->close();
















