<?php
session_start();
require_once 'db.php';

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the leaderboard from the database
$query = "SELECT name, score FROM studentsdata ORDER BY score DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 80%;
            max-width: 700px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }
        p {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background: #4CAF50;
            color: white;
            font-size: 16px;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        tr:hover {
            background: #d1f5d3;
        }
        td {
            font-size: 15px;
            color: #333;
        }
        .rank-1 {
            font-weight: bold;
            color: gold;
        }
        .rank-2 {
            font-weight: bold;
            color: silver;
        }
        .rank-3 {
            font-weight: bold;
            color: #cd7f32;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🏆 Leaderboard 🏆</h2>
        <p>Welcome, <strong><?php echo $_SESSION['student_name']; ?></strong>!</p>
        <table>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
            </tr>
            <?php
            $rank = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $class = "";
                if ($rank == 1) $class = "rank-1";
                elseif ($rank == 2) $class = "rank-2";
                elseif ($rank == 3) $class = "rank-3";

                echo "<tr class='$class'>";
                echo "<td>" . $rank++ . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['score'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>