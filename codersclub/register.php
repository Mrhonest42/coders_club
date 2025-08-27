<?php
// Connection to the database
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $plainpass = $_POST['password'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if(strlen($name)<4 || strlen($name)>16){
        echo"Invalied name";
        exit();
    }
    if(strlen($password)<8 || strlen($password)>16){
        echo "Invalied password";
        exit();
    }

    // Insert the student details into the database
    $query = "INSERT INTO studentsdata (name, email, plainpass, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
</head>
<body>
    <h2>Student Registration</h2>
    <form method="post" action="">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>
