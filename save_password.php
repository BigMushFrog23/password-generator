<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo "You must be logged in to save passwords.";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password = trim($_POST['password'] ?? '');

  if (empty($password)) {
    echo "Password cannot be empty.";
    exit;
  }

  // Connect to database
  $conn = new mysqli("localhost", "root", "", "diceware_app");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO passwords (user_id, password) VALUES (?, ?)");
  $stmt->bind_param("is", $_SESSION['user_id'], $password);

  if ($stmt->execute()) {   
    echo "Password saved successfully!";
  } else {
    echo "Failed to save password.";
  }

  $stmt->close();
  $conn->close();
}
?>
