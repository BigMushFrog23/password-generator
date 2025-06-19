<?php
session_start();
require 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "Login successful";
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}
?>