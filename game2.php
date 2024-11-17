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
  <title>Quiz Game</title>
  <link rel="stylesheet" href="game.css">
  <style>
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

  <div id="feedback-overlay">
    <div id="feedback-message">  </div>
    <button onclick="goHome()">🏠</button>
    <button onclick="restartGame()">🔄</button>
  </div>

  <script>
    let answerOptions = [];
    let correctAnswer;
    const feedbackOverlay = document.getElementById('feedback-overlay');
    const feedbackMessage = document.getElementById('feedback-message');
    let timerInterval;  

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
      .catch(error => {
        console.error('Error fetching data:', error);
      });

function getQueryParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

const difficultyLevel = getQueryParameter('level');
let timerDuration;

if (difficultyLevel === 'Easy') {
    timerDuration = 30; 
} else if (difficultyLevel === 'Medium') {
    timerDuration = 20; 
} else if (difficultyLevel === 'Hard') {
    timerDuration = 10; 
} 

function startTimer() {
    let timeLeft = timerDuration;
    const timerFill = document.getElementById('timer-fill');
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

    function checkAnswer(answer) {
      clearInterval(timerInterval);  
      if (answer === correctAnswer) {
        showFeedback("Wow, you're right!", "green", "<br>");
      } else {
        showFeedback("Oops, try again!", "red", "<br>");
      }
    }

    function goHome() {
      window.location.href = 'level.php';  
    }

    function restartGame() {
      location.reload(); 
    }
  </script>

</body>
</html>
