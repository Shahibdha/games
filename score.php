<?php
session_start();

if ($_GET['confirmed'] ?? '' === 'true') {
    session_destroy(); // Destroy the session and unset all session variables
    header('Location: login.php'); // Redirect to the login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
</head>
<body>
    <a href="?confirmed=true">
        <button>Logout</button>
    </a>
</body>
</html>
