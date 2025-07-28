<?php
session_start();
include("includes/db.php");

// Redirect if student not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch all quizzes
$quizQuery = "SELECT * FROM quizzes WHERE status='active'";
$quizResult = mysqli_query($conn, $quizQuery);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Quiz Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
      color: white;
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

    .profile-icon {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: #0d6efd;
      color: white;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-right: 10px;
    }

    .card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: white;
      transition: transform 0.2s ease-in-out;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card .badge {
      font-size: 0.75rem;
    }

    h3, .fw-bold {
      color: #ffffff;
      text-shadow: 1px 1px 3px #000;
    }

    .btn-logout {
      background: none;
      color: white;
      border: 2px solid white;
      transition: all 0.3s ease-in-out;
    }

    .btn-logout:hover {
      background-color: #c82333;
      transform: scale(1.05);
      box-shadow: 0 0 10px rgba(255, 0, 0, 0.4);
    }

    .btn-success {
      background-color: #28a745 !important;
    }
  </style>
</head>
<body>
  <video autoplay muted loop id="bg-video">
    <source src="videos/quiz_interface.mp4" type="video/mp4">
  </video>

<div class="container py-3 mt-5">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
      <div class="profile-icon"><?= strtoupper(substr($_SESSION['student_name'], 0, 1)) ?></div>
      <span class="fw-bold fs-5"><?= htmlspecialchars($_SESSION['student_name']) ?></span>
    </div>
    <div>
      <button class="btn btn-logout" id="logout">Logout</button>
    </div>
  </div>

  <h3 class="mb-3">Available Quizzes</h3>

  <div class="row">
    <?php while($quiz = mysqli_fetch_assoc($quizResult)): ?>
      <div class="col-lg-6 mb-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($quiz['title']) ?>
              <?php if ($quiz['status'] == 'active'): ?>
                <span class="badge bg-success">Quiz is now open</span>
              <?php else: ?>
                <span class="badge bg-secondary">Not Open</span>
              <?php endif; ?>
            </h5>
            <p class="card-text"><?= htmlspecialchars($quiz['description']) ?></p>
            <?php if ($quiz['status'] == 'active'): ?>
              <a href="quiz.php?quiz_id=<?= $quiz['id'] ?>" class="btn btn-success">Start Quiz</a>
            <?php else: ?>
              <button class="btn btn-secondary" disabled>Not Available</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  document.getElementById("logout").addEventListener('click', () => {
    window.location.href = "index.php";
  });
</script>
</body>
</html>