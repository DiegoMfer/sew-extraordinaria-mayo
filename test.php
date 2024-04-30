<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
$servername = "localhost";
$username = "test";
$password = "test";
$dbname = "sew";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// Close connection
$conn->close();

?>