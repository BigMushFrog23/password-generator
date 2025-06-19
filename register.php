<?php
session_start();
require 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hash);

if ($stmt->execute()) {
    echo "User registered successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>