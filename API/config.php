<?php

/* Autoload of classes */
function __autoload($class_name) {
    include "../classes/" . $class_name . ".class.php";
} 


error_reporting(-1);            //Report all type of errors
ini_set("display_errors", 1);   //Display all error



$devmode = false; //om jag vill publicera sätt devmode till false.

if($devmode){
    /* Database-settings (localhost) */
    define("DBHOST", "localhost;8080");
    define("DBUSER", "elin_cv");
    define("DBPASS", "elin_cv");
    define("DBDATABASE", "elin_cv");

}else {
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "elku1901");
    define("DBPASS", "fkdd7cpm");
    define("DBDATABASE", "elku1901");
}
