<?php
include ('classes/Database.class.php');
include('includes/config.php');

/* Anslut till databasen */
//connect to database
$database = new Database();
$db = $database->connect();

// First query
$sql = 'DROP TABLE IF EXISTS education;';
$sql .= '
CREATE TABLE IF NOT EXISTS `education` (
   `id` INT(11) NOT NULL AUTO_INCREMENT,
   `edu_school` VARCHAR(100) NOT NULL,
   `edu_name` VARCHAR(100) NOT NULL,
   `edu_start` DATE NOT NULL,
   `edu_stop` DATE NOT NULL,
   `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8';


// Prepare the query and execute it
$stmt = $db->prepare($sql);
if($stmt->execute()) {
   echo '<p>Tabellen "education" har lagts till</p>';
   echo '<pre>' . $sql . '</pre>';
} else {
   echo '<p>Gick inte att lägga till tabellen "education"</p>';
}

// Second query
$sql = 'DROP TABLE IF EXISTS work;';
$sql .= '
CREATE TABLE IF NOT EXISTS `work` (
   `id` INT(11) NOT NULL AUTO_INCREMENT,
   `work_place` VARCHAR(64) NOT NULL,
   `work_title` VARCHAR(64) NOT NULL,
   `work_start` DATE NOT NULL,
   `work_stop` DATE NOT NULL,
   `work_city` VARCHAR(64) NOT NULL,
   `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8';

// Prepare the query and execute it
$stmt = $db->prepare($sql);
if($stmt->execute()) {
   echo '<p>Tabellen "work" har lagts till</p>';
   echo '<pre>' . $sql . '</pre>';
} else {
   echo '<p>Gick inte att lägga till tabellen "work"</p>';
}

// Third query
$sql = 'DROP TABLE IF EXISTS websites;';
$sql .= '
CREATE TABLE IF NOT EXISTS `websites` (
   `id` INT(11) NOT NULL AUTO_INCREMENT,
   `ws_title` VARCHAR(100) NOT NULL UNIQUE,
   `ws_url` VARCHAR(100) NOT NULL,
   `ws_description` TEXT NOT NULL,
   `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8';

// Prepare the query and execute it
$stmt = $db->prepare($sql);
if($stmt->execute()) {
   echo '<p>Tabellen "websites" har lagts till</p>';
   echo '<pre>' . $sql . '</pre>';
} else {
   echo '<p>Gick inte att lägga till tabellen "websites"</p>';
}

// Close connection
$db = $database->close();




