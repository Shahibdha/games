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
    <h1 class="header1">Choose Your <span class="header1span">Level</span></h1>
    <div class="container">
        <div class="levels">
            <div class="level1" onclick="chooseLevel('Easy')">Easy</div>
        </div>
        <div class="levels">
            <div class="level1" onclick="chooseLevel('Medium')">Medium</div>
        </div>
        <div class="levels">
            <div class="level1" onclick="chooseLevel('Hard')">Hard</div>
        </div>
    </div>
    <div id="beginMessage" class="begin-message">Let's Begin!</div>

<script>
    let chosenLevel = null;

    function chooseLevel(level) {
        chosenLevel = level;
        showBeginMessage();

        let gamePage = `game2.php?level=${level}`;

        setTimeout(function() {
            window.location.href = gamePage;
        }, 2000);
    }


    function showBeginMessage() {
        if (chosenLevel) {
            const message = document.getElementById('beginMessage');
            message.style.display = 'block';
            message.classList.add('show');
        }
    }
</script>
</body>
</html>
