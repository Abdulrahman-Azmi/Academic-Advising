<?php

include_once 'psl-config.php';

// Create connection
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
$connection->set_charset("UTF8");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 

// Testing to see if conected!
// echo "Connected successfully";

?>