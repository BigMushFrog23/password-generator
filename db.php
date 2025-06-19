<?php
$host = "localhost";
$dbname = "diceware_app";
$user = "root"; // default XAMPP user
$pass = "";     // default is empty

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
