<?php
session_start();
session_unset();
session_destroy();

// Optional: redirect to login page (if accessed directly)
header("Location: login.html");
exit;
?>
