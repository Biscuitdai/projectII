<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movieproject";

// Create a new MySQLi object to establish a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}
?>
