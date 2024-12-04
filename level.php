<?php
session_start(); 

if (!isset($_SESSION["emailid"])) {
    header("Location: login.php"); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Level</title>
    <link rel="stylesheet" href="level.css">
</head>
<body>
    <h1>Choose Your <span>Level</span></h1>
    <div class="container">
        <div class="levels">
            <div class="level1" onclick="chooseLevel('Easy')">Easy</div>
            <div class="level1" onclick="chooseLevel('Medium')">Medium</div>
            <div class="level1" onclick="chooseLevel('Hard')">Hard</div>
        </div>
    </div>
    
    <script>
        function chooseLevel(level) {
            window.location.href = `game2.php?level=${level}`;
        }
    </script>
</body>
</html>
