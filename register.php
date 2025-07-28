<?php
include("includes/db.php");

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $reg = trim($_POST['reg_no']);
    $dept = trim($_POST['department']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobileno']);
    $pass1 = $_POST['createpassword'];
    $pass2 = $_POST['confirmpassword'];

    if (empty($name) || empty($reg) || empty($dept) || empty($email) || empty($mobile) || empty($pass1) || empty($pass2)) {
        $error = "All fields are required.";
    } elseif ($pass1 !== $pass2) {
        $error = "Passwords do not match.";
    } else {
        // Check for duplicates
        $check = $conn->prepare("SELECT * FROM students WHERE reg_no=? OR email=? OR mobile_no=?");
        $check->bind_param("sss", $reg, $email, $mobile);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "User already exists with this Register No, Email, or Mobile No.";
        } else {
            $hashed_pass = password_hash($pass1, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO students (name, reg_no, department, email, mobile_no, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $reg, $dept, $email, $mobile, $hashed_pass);

            if ($stmt->execute()) {
                header("Location: register.php?success=1");
                exit();
            } else {
                $error = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Register - AI Dept</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      overflow-x: hidden;
    }

    #bg-video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
      filter: blur(2px) brightness(0.4);
    }


    .form-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 16px;
      padding: 30px;
      max-width: 500px;
      margin: 80px auto;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      animation: fadeIn 1s ease-in;
    }

    @media (max-width: 576px) {
      .form-container {
        margin: 30px 15px;
        padding: 20px;
      }
    }

    input:focus, select:focus {
      border-color: #00f2ff;
      box-shadow: 0 0 12px #00f2ff;
      transform: scale(1.02);
      transition: all 0.25s ease;
    }

    h3 {
      text-align: center;
      color:rgb(113, 181, 248);
    }

    button {
      border-radius: 30px;
      font-weight: 500;
    }

    a {
      color: #0066cc;
    }

    a:hover {
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .toast-container {
      position: fixed;
      top: 1rem;
      right: 1rem;
      z-index: 1055;
    }

    input::placeholder {
      color: #ccc;
      opacity: 1;
      transition: transform 0.3s ease, font-size 0.3s ease;
    }

    input:focus::placeholder {
      transform: translateY(-10px);
      font-size: 0.85em;
      color: #00f2ff;
    }

  </style>
</head>
<body>

<!-- 🔮 AI Background Video -->
<video autoplay muted loop id="bg-video">
  <source src="videos/register_animation.mp4" type="video/mp4">
</video>

<!-- ✅ Toast after success -->
<?php if (isset($_GET['success'])): ?>
  <div class="toast-container">
    <div class="toast align-items-center text-white bg-success border-0 show">
      <div class="d-flex">
        <div class="toast-body">🎉 Registration successful! <a href="index.php" class="btn btn-link">Login here</a></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- 📝 Registration Form -->
<div class="container">
  <div class="form-container">
    <h3>Student Registration</h3>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="d-flex flex-column gap-3 mt-3">
      <input name="name" class="form-control" placeholder="Full Name with Initial" required>
      
      <select name="department" class="form-control" required>
        <option value="">Select your department</option>
        <option>Artificial Intelligence</option>
        <option>Computer Science</option>
        <option>IT Department</option>
        <option>Bvoc. SD & SA</option>
        <option>Mathematics</option>
        <option>Statistics</option>
        <option>Physics</option>
        <option>Chemistry</option>
        <option>Botony</option>
        <option>Biotechnoly</option>
        <option>Biochemistry</option>
        <option>Commerce</option>
        <option>Economics</option>
        <option>Tamil</option>
        <option>English</option>
        <option>Histry</option>
        <option>Viscom</option>
      </select>

      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="tel" name="mobileno" class="form-control" placeholder="Mobile Number" pattern="[0-9]{10}" required>
      <input name="reg_no" class="form-control" placeholder="Register No" required>
      <input type="password" name="createpassword" class="form-control" placeholder="Create Password" required>
      <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>

      <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <p class="mt-3 text-center">
      <a href="index.php">Already have an account? Login</a>
    </p>
  </div>
</div>

<!-- Bootstrap JS (Toast) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const toastEl = document.querySelector('.toast');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }
  });
</script>

</body>
</html>