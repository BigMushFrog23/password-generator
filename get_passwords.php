<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(["error" => "You must be logged in to view saved passwords."]);
  exit;
}

$conn = new mysqli("localhost", "root", "", "diceware_app");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Database connection failed."]);
  exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, password FROM passwords WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$passwords = [];
while ($row = $result->fetch_assoc()) {
  $passwords[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($passwords);
?>
