<?php
session_start();
include("includes/db.php");

// Prevent browser back navigation cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if quiz_id is provided
if (!isset($_GET['quiz_id'])) {
    echo "Quiz not selected.";
    exit();
}

$quiz_id = $_GET['quiz_id'];

// Fetch quiz details
$quizQuery = mysqli_query($conn, "SELECT * FROM quizzes WHERE id = $quiz_id");
$quiz = mysqli_fetch_assoc($quizQuery);
$time_limit = (int)$quiz['time_limit'];

// Fetch questions
$questionQuery = mysqli_query($conn, "SELECT * FROM questions WHERE quiz_id = $quiz_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($quiz['title']) ?> | Quiz</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .timer {
      font-size: 1.5rem;
      font-weight: bold;
      color: green;
    }
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
    }

    /* Background Video Styling */
    #bg-video {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .animated {
  animation: fadeInUp 0.4s ease-out;
}
.overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100vw; height: 100vh;
  background: rgba(255, 255, 255, 0.7); /* Light overlay */
  z-index: -1;
}

  </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center">
  
  <video autoplay muted loop id="bg-video">
    <source src="videos/admin_dashboard.mp4" type="video/mp4">
  </video>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 style="color: #fff;"><?= htmlspecialchars($quiz['title']) ?></h3>
    <div class="timer" id="timer">Time Left: <?= $time_limit ?>:00</div>
  </div>

  <form method="POST" action="result.php" id="quizForm">
    <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">

    <?php
$questions = [];
while ($q = mysqli_fetch_assoc($questionQuery)) {
    $questions[] = $q;
}
?>

<div id="question-container">
  <!-- Questions injected here by JavaScript -->
</div>

<div class="d-flex justify-content-between mt-3">
  <button type="button" class="btn btn-info" id="prevBtn">Previous</button>
  <button type="button" class="btn btn-success" id="nextBtn">Next</button>
</div>

<div class="text-center mt-4">
  <button type="submit" class="btn btn-primary px-5">Submit</button>
</div>
  </form>
</div>

<!-- JS Timer and Navigation Protection -->
<script>
  // Timer Countdown
  let timeLeft = <?= $time_limit ?> * 60;
  const timerEl = document.getElementById("timer");

  const countdown = setInterval(() => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    timerEl.textContent = `Time Left: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    timeLeft--;

    if (timeLeft < 0) {
      clearInterval(countdown);
      alert("Time's up! Your answers will be submitted automatically.");
      document.getElementById("quizForm").submit();
    }
  }, 1000);

  // Disable back navigation
  history.pushState(null, null, location.href);
  window.onpopstate = function () {
    history.go(1);
  };
  const questions = <?= json_encode($questions) ?>;
  let currentIndex = 0;
let answers = {};


  function renderQuestion(index) {
  const q = questions[index];
  const container = document.getElementById("question-container");

  const selected = answers[q.id] || '';

  container.innerHTML = `
    <div class="card mb-3 fs-4 animated fadeIn" style="background-color: rgba(255, 255, 255, 0.15); color: #fff;">
      <div class="card-body">
        <p><strong>Q${index + 1}. ${q.question_text}</strong></p>
        ${['A', 'B', 'C', 'D'].map(letter => `
          <div class="form-check">
            <input class="form-check-input" type="radio" name="q${q.id}" value="${letter}" id="q${q.id}${letter.toLowerCase()}"
              ${selected === letter ? 'checked' : ''}>
            <label class="form-check-label" for="q${q.id}${letter.toLowerCase()}">${q['option_' + letter.toLowerCase()]}</label>
          </div>
        `).join('')}
      </div>
    </div>
  `;

  // Capture selection
  document.querySelectorAll(`input[name="q${q.id}"]`).forEach(input => {
    input.addEventListener("change", e => {
      answers[q.id] = e.target.value;
    });
  });

  // Disable Prev/Next
  document.getElementById("prevBtn").disabled = index === 0;
  document.getElementById("nextBtn").disabled = index === questions.length - 1;
}

  document.getElementById("prevBtn").addEventListener("click", () => {
    if (currentIndex > 0) {
      currentIndex--;
      renderQuestion(currentIndex);
    }
  });

  document.getElementById("nextBtn").addEventListener("click", () => {
    if (currentIndex < questions.length - 1) {
      currentIndex++;
      renderQuestion(currentIndex);
    }
  });

  // Initial render
  renderQuestion(currentIndex);
  document.getElementById("quizForm").addEventListener("submit", function (e) {
  Object.keys(answers).forEach(qid => {
    const hidden = document.createElement("input");
    hidden.type = "hidden";
    hidden.name = `answers[${qid}]`;
    hidden.value = answers[qid];
    this.appendChild(hidden);
  });
});
</script>

</body>
</html>