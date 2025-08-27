<?php
// Include DB connection (optional)
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $plainpass = trim($_POST['password']);

    // Example: Insert into database
    $sql = "INSERT INTO studentsdata (name, email, plain_password, hashed_password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $plainpass, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful!');</script>";
    } else {
        echo "<script>alert('Error: Could not register');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <form method="POST" action="">
        <h2>Create an Account</h2>
        
        <div class="input-group">
            <input type="text" name="name" required>
            <label>Full Name</label>
        </div>

        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="input-group">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>

        <button type="submit">Register</button>
        <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>

</body>
</html>
