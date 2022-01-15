<?php
$servername = "182.50.133.82:3306";
$username = "myhost";
$password = "@rjiT#2408";
$dbname = "myfamily";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>