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
$work = new Work($db);



switch($method) {
    case 'GET':
        if(isset($id)) {
            //function to read row with specific id
            $result = $work->readOneWork($id);
        } else {
            //function to read data from table
            $result = $work->readWork();       
        }

        //Check if result isn't empty
        if(!$result) {
            http_response_code(404); //not found
            $result = array("message" => "Inga jobb hittade");
        } else {
            http_response_code(200); //ok
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        //Remove tags and makes special characters availble to store
        //and send input to the class proterties
        $work->work_place = $data->work_place;
        $work->work_title = $data->work_title;
        $work->work_start = $data->work_start;
        $work->work_stop = $data->work_stop;
        $work->work_city = $data->work_city;

        //Function to create row
        if($work->create($data->work_place, $data->work_title, $data->work_start, $data->work_stop, $data->work_city)) {
            http_response_code(201); //created
            $result = array("message" => "Jobb tillagd");
        } else {
            http_response_code(503); //Server error
            $result = array("message" => "Jobb EJ tillagd");
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
        $work->work_place = $data->work_place;
        $work->work_title = $data->work_title;
        $work->work_start = $data->work_start;
        $work->work_stop = $data->work_stop;
        $work->work_city = $data->work_city;

        //run function for update row
        if($work->updateWork($id, $data->work_place, $data->work_title, $data->work_start, $data->work_stop, $data->work_city)) {
            http_response_code(200); //ok
            $result = array("message" => "Jobbet är uppdaterat");
        } else {
            http_response_code(503); //server error
            $result = array("message" => "Jobbet är inte uppdaterat");
        }
    break;
    case 'DELETE':
        //if no id is sent - send error
        if(!isset($id)) {
            http_response_code(510); //Not extended
            $result = array("message" => "Inget id är skickat");
        } else {
            if($work->deleteWork($id)) {
                http_response_code(200); //ok
                $result = array("message" => "Jobbet är raderat");
            } else {
                http_response_code(503); //Server error
                $result = array("message" => "Jobbet är inte raderat");
            }
        }
    break;

}

//return result as json
echo json_encode($result, JSON_PRETTY_PRINT);

//close database connection
$db = $database->close();
















