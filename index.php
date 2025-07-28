<?php
session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg = $_POST['reg_no'];
    $pass = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM students WHERE reg_no = '$reg'");
    $student = mysqli_fetch_assoc($q);

    if ($student && password_verify($pass, $student['password'])) {
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        header("Location: quiz_interface.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
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

    .login-card {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(15px);
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
      animation: fadeInUp 1s ease;
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
      transition: all 0.3s ease-in-out;
      transform: scale(1.02);
    }

    .admin-btn-wrapper {
  position: absolute;
  top: 20px;
  right: 20px;
  z-index: 10;
}

.admin-btn {
  padding: 10px 22px;
  font-weight: 600;
  font-size: 15px;
  color: #ffffff;
  background: rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 10px;
  backdrop-filter: blur(6px);
  transition: all 0.4s ease;
  text-decoration: none;
  box-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
}

.admin-btn:hover {
  background: linear-gradient(135deg, rgba(13, 110, 253, 0.7), rgba(102, 16, 242, 0.7));
  color: #fff;
  box-shadow: 0 0 15px rgba(102, 16, 242, 0.5);
  transform: translateY(-2px) scale(1.05);
}

    .card-title {
      font-weight: bold;
      color: #fff;
    }

    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-card a {
      color: #fff;
      text-decoration: underline;
    }

    .alert {
      background: rgba(255, 0, 0, 0.7);
      border: none;
      color: #fff;
    }
  </style>
</head>
<body>
  <!-- AI Video Background -->
  <video autoplay muted loop id="bg-video">
    <source src="videos/register_animation.mp4" type="video/mp4">
  </video>

  <!-- Admin Button -->
  <!-- Admin Button -->
  <div class="admin-btn-wrapper">
    <a href="admin.php" class="admin-btn">Administrator</a>
  </div>


  <!-- Login Form Card -->
  <div class="container">
    <div class="login-card w-100" style="max-width: 420px;">
      <h3 class="text-center text-white mb-4">Student Login</h3>
      <?php if (isset($error)): ?>
        <div class="alert"><?= $error ?></div>
      <?php endif; ?>
      <form method="POST" class="d-flex flex-column gap-3">
        <input name="reg_no" class="form-control" placeholder="Register No" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      <p class="mt-3 text-center"><a href="register.php">Don't have an account? Register</a></p>
    </div>
  </div>
</body>
</html>