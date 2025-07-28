<?php
$host = "localhost";
$user = "root";       // default for XAMPP
$pass = "";           // default for XAMPP
$dbname = "coders_club";  // name you'll use in phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>