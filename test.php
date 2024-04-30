
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// MySQL server credentials
$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "your_username"; // Change this to your MySQL username
$password = "your_password"; // Change this to your MySQL password
$database = "your_database"; // Change this to your MySQL database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

// Close connection
mysqli_close($conn);
?>