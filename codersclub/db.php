<?php
$servername = "localhost";
$username = "root"; // change to your database username
$password = ""; // change to your database password
$dbname = "coders_club"; // your database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
