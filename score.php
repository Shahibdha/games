<?php
session_start(); 

$con = mysqli_connect("localhost", "root", "", "game");

if (!isset($_SESSION["emailid"])) {
    header("Location: login.php");
    exit();
}

$email = mysqli_real_escape_string($con, $_SESSION['emailid']); 

$sql = "SELECT `player`, SUM(`score`) AS total_score FROM `score` GROUP BY `player` ORDER BY total_score DESC;"; 
$result2 = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Scoreboard</title>
    <link rel="stylesheet" href="login.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #222;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 20px;
            background-image: url('images/banana2.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
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
        .scoreboard{
            position: relative; 
            z-index: 2;
        }
        .scoreboard {
            margin: auto;
            max-width: 600px;
            padding: 20px;
            border: 2px solid #444;
            border-radius: 10px;
            background: #333;
            width: 80%;
        }
        header {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #444;
        }

        th {
            background: #444;
        }

        footer {
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="scoreboard">
        <header>
            <h1>Game Scoreboard</h1>
        </header>
        <section class="leaderboard">
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody id="scoreboard-entries">
                    <?php 
                    $rank = 1;
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $player = $row['player'];
                            $total_score = $row['total_score'];

                            echo "<tr>";
                            echo "<td>" . $rank++ . "</td>";  
                            echo "<td>" . $player . "</td>"; 
                            echo "<td>" . $total_score . "</td>";  
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <footer>
            <a href="main.php">
                <button id="restart-game" class="btn">Back to Home</button>
            </a>
        </footer>
    </div>
</body>
</html>
