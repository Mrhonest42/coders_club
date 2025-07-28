<?php
session_start();
include("includes/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    if ($password == '1234') { // You can change this later to check DB
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
    }

    #bg-video {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
    }

    .login-container {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .card {
      backdrop-filter: blur(10px);
      background-color: rgba(255, 255, 255, 0.15);
      border-radius: 15px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
      animation: fadeInUp 0.8s ease forwards;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
      transform: scale(1.02);
      transition: 0.3s ease-in-out;
    }

    h3 {
      color: white;
    }

    label, .alert {
      color: white;
    }
  </style>
</head>
<body>

<video autoplay muted loop id="bg-video">
  <source src="videos/register_animation.mp4" type="video/mp4">
</video>

<div class="login-container">
  <div class="col-md-5 col-sm-10">
    <div class="card p-4">
      <h3 class="text-center mb-4">Admin Login</h3>

      <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>

    </div>
  </div>
</div>

</body>
</html>