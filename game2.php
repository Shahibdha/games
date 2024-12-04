<?php
session_start(); 

$con = mysqli_connect("localhost", "root", "", "game");

if (!isset($_SESSION["emailid"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["score"]) && isset($_SESSION['emailid'])) {
  $score = intval($_POST["score"]);
  $email = mysqli_real_escape_string($con, $_SESSION['emailid']); 

  $sql = "INSERT INTO `score` (`id`, `player`, `score`) VALUES (NULL, '$email', '$score')";

  if (mysqli_query($con, $sql)) {
      echo "Score saved successfully!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Game</title>
  <link rel="stylesheet" href="game.css">
  <style>
    body {
      background-image: url('images/banana2.jpeg');
      background-size: cover;
      background-position: center;
      height: 93vh;
      padding-top: 20px;
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
    #question, #timer-bar, #answers, #score-form {
        position: relative;
        z-index: 2;
    }
    #feedback-overlay button {
      display: flex;
      padding: 10px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 50px;
      color: white;
      background-color: #333;
    }
    #feedback-overlay button:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <div id="timer-bar">
    <div id="timer-fill"></div>
  </div>

  <div id="question">
    <img id="question-image" src="" alt="Question Image">
  </div>

  <div id="answers">
    <button class="answer-button" onclick="checkAnswer(answerOptions[0])" id="btn1"></button>
    <button class="answer-button" onclick="checkAnswer(answerOptions[1])" id="btn2"></button>
    <button class="answer-button" onclick="checkAnswer(answerOptions[2])" id="btn3"></button>
    <button class="answer-button" onclick="checkAnswer(answerOptions[3])" id="btn4"></button>
  </div>

  <form method="POST" action="" id="score-form" >
    <div id="feedback-overlay" style="display: none">
      <div class="containeroverlay" style="display: flex; flex-direction: column;">
        <div id="feedback-message"></div>
        <input type="hidden" name="score" id="score" value="0">
        <center>
        <div class="buttoncontainer" style="display: flex; width:150px;">
          <button type="button" onclick="goHome()">🏠</button>
          <button type="button" onclick="restartGame()">🔄</button>
        </div>
        </center>
      </div>
    </div>
</form>


  <script>
  let score = 0; 
  let answerOptions = [];
  let correctAnswer;
  const feedbackOverlay = document.getElementById('feedback-overlay');
  const feedbackMessage = document.getElementById('feedback-message');
  let timerInterval;
  const timerFill = document.getElementById('timer-fill');
  
  fetch('https://marcconrad.com/uob/banana/api.php')
    .then(response => response.json())
    .then(data => {
      const questionImage = data.question;
      correctAnswer = data.solution;
      document.getElementById('question-image').src = questionImage;

      answerOptions = [correctAnswer];
      while (answerOptions.length < 4) {
        const randomNum = Math.floor(Math.random() * 10) + 1;
        if (!answerOptions.includes(randomNum)) {
          answerOptions.push(randomNum);
        }
      }
      answerOptions = answerOptions.sort(() => Math.random() - 0.5);

      document.getElementById('btn1').textContent = answerOptions[0];
      document.getElementById('btn2').textContent = answerOptions[1];
      document.getElementById('btn3').textContent = answerOptions[2];
      document.getElementById('btn4').textContent = answerOptions[3];

      startTimer();
    })
    .catch(error => console.error('Error fetching data:', error));

  const difficultyLevel = new URLSearchParams(window.location.search).get('level');
  let timerDuration = 20; 

  if (difficultyLevel === 'Easy') {
    timerDuration = 30;
  } else if (difficultyLevel === 'Medium') {
    timerDuration = 20;
  } else if (difficultyLevel === 'Hard') {
    timerDuration = 10;
  }

  function startTimer() {
    let timeLeft = timerDuration;
    timerFill.style.width = '100%';

    timerInterval = setInterval(() => {
      timeLeft--;
      timerFill.style.width = (timeLeft / timerDuration) * 100 + '%';

      if (timeLeft < 0) {
        clearInterval(timerInterval);
        showFeedback("Time's up! Try again!", "red");
      }
    }, 1000);
  }

  function showFeedback(message, color) {
    feedbackMessage.textContent = message;
    feedbackMessage.style.color = color;
    feedbackOverlay.style.display = 'flex';
  }

  function calculateScore() {
    if (difficultyLevel === 'Easy') {
      score = 5;
    } else if (difficultyLevel === 'Medium') {
      score = 10;
    } else if (difficultyLevel === 'Hard') {
      score = 15;
    }
  }

  function updateScore(newScore) {
    score = newScore;
    document.getElementById('score').value = score;
  }

  function sendScoreToDB() {
    const form = document.getElementById('score-form');
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      body: formData,
    })
      .then(response => response.text())
      .then(data => console.log('Score saved:', data))
      .catch(error => console.error('Error saving score:', error));
  }

  function checkAnswer(answer) {
    clearInterval(timerInterval);
    if (answer === correctAnswer) {
      calculateScore();
      updateScore(score);
      sendScoreToDB();
      showFeedback(`Correct! Score: ${score}`, "green");
    } else {
      score = 0;
      updateScore(score);
      sendScoreToDB();
      showFeedback(`Incorrect! Score: ${score}`, "red");
    }
  }

  function goHome() {
    window.location.href = 'main.php';
  }

  function restartGame() {
    location.reload();
  }
</script>
</body>
</html>
