<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/dist/supabase.min.js"></script>
<script>
  const supabaseUrl = 'YOUR_SUPABASE_URL';
  const supabaseAnonKey = 'YOUR_SUPABASE_ANON_KEY';
  const supabase = supabase.createClient("https://ylaukgzoebsprbnwywfq.supabase.co", "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InlsYXVrZ3pvZWJzcHJibnd5d2ZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTAzMzEzNTQsImV4cCI6MjA2NTkwNzM1NH0.9LXhRjOcS2fSU5UxceaXA1ET6zYc9NLqfhW-9qtT4tg");
</script>

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