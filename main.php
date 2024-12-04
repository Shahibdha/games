<?php
session_start(); 

if (!isset($_SESSION["emailid"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Dashboard</title>
    <link rel="stylesheet" href="login.css">
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('images/banana2.jpeg');
            background-size: cover;
            background-position: center;
            height: 97vh;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            z-index: 1; 
        }
        .container, .quotescontainer {
            position: relative; 
            z-index: 2;
        }
        .container {
            text-align: center;
            background: #333;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 40%;
        }
        .btn {
            width: 500px;
            margin: 10px 0;
        }
        .quotescontainer{
            height: auto;
            padding: 20px;
            color: white;
        }
    </style>
</head>
<body>
   
    <div class="container">
    <div class="quotescontainer">
        <center><div id="quote"></div></center>
        <center><div id="name" style="color: yellow"></div></center>
    </div>
        <a href="level.php">
            <button class="btn">Game</button><br>
        </a>
        <a href="score.php">
            <button class="btn">Scoreboard</button><br>
        </a>
        <a href="logout.php">
            <button class="btn">Logout</button>
        </a>
    </div>

<script>
    fetch('https://api.api-ninjas.com/v1/quotes', {
        method: 'GET',
        headers: {
            'X-Api-Key': 'buPO48FfTMRXOMC/ucRAUQ==GmjgaoeYL8a38ewJ'
        }
    })
    .then(response => response.json())
    .then(data => {
        const quote = data[0].quote; 
        const name = data[0].author;  

        document.getElementById('quote').textContent = quote;  
        document.getElementById('name').textContent = name;   

        console.log(data);
    })
</script>

</body>
</html>
