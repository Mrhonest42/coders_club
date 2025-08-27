<?php
session_start();

// Example: Protect page if not logged in
if (!isset($_SESSION['student_name'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['student_name']; // From login session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="sidebar">
    <h2>CODERS CLUB</h2>
    <ul>
        <li><a href="#">🏠 Dashboard</a></li>
        <li><a href="leaderboard.php">📄 Leader Board</a></li>
        <li><a href="#">👤 Profile</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user); ?> 👋</h1>
    </header>

    <section class="cards">
        <div class="card">
            <h3>📊 Total Students</h3>
            <p>120</p>
        </div>
        <div class="card">
            <h3>✅ Tasks Completed</h3>
            <p>85%</p>
        </div>
        <div class="card">
            <h3>📅 Upcoming Events</h3>
            <p>3</p>
        </div>
    </section>

    <section class="table-section">
        <h2>Recent Registrations</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th><th>Email</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Example: Replace with your database query
                echo "<tr><td>John Doe</td><td>john@example.com</td><td>2025-08-12</td></tr>";
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>
