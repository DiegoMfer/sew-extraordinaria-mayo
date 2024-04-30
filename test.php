<?php
$servername = "20.19.35.195";
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