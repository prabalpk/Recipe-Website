<?php
$host = "localhost";   
$dbname = "recipe_app";   // Your database name
$username = "root";       // Your MySQL username 
$password = "";           // Your MySQL password 

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    // echo "connection successfull";
?>
