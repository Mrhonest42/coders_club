<?php
include("includes/db.php");
include("submit.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Quiz Result</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .result-container {
      max-width: 1000px;
      margin: auto;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .left-section {
      padding: 40px;
    }
    .video-container video {
      width: 100%;
      max-width: 400px;
      border-radius: 10px;
    }
    @media (max-width: 768px) {
      .flex-md-row {
        flex-direction: column !important;
      }
      .video-container {
        text-align: center;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="result-container d-flex flex-md-row flex-column align-items-center">
      
      <!-- Left Content -->
      <div class="left-section col-md-6 text-center text-md-start">
        <h2 class="mb-3">🎉 Quiz Completed!</h2>
        <p class="fs-4">
          You scored <strong><?= $score ?></strong> out of <strong><?= $total_questions ?></strong>.
        </p>
        <a href="index.php" class="btn btn-success mt-3">Back to Home</a>
      </div>

      <!-- Right Video -->
      <div class="video-container col-md-6 text-center p-3">
        <video autoplay muted loop playsinline>
          <source src="submission.mp4" type="video/mp4">
        </video>
      </div>

    </div>
  </div>
</body>
</html>