<?php
session_start();
include("includes/db.php");

if (!isset($_POST['quiz_id']) || !isset($_POST['answers']) || !isset($_SESSION['student_id'])) {
    echo "Quiz Completed. No questions answered";
    echo "<a href='index.php' style='text-decoration: none;'>Back to home</a>";
    exit();
}

$quiz_id = $_POST['quiz_id'];
$student_id = $_SESSION['student_id'];
$submitted_answers = $_POST['answers'];

// Fetch all correct answers
$query = "SELECT id, correct_option FROM questions WHERE quiz_id = $quiz_id";
$result = mysqli_query($conn, $query);

$total_questions = mysqli_num_rows($result);
$score = 0;
$attempted = 0;
$unanswered = 0;
$wrong = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $qid = $row['id'];
    $correct = $row['correct_option'];

    if (isset($submitted_answers[$qid])) {
        $attempted++;
        if ($submitted_answers[$qid] == $correct) {
            $score++;
        } else {
            $wrong++;
        }
    } else {
        $unanswered++;
    }
}

$percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;

// Insert into results table
$insert = "INSERT INTO results 
    (quiz_id, student_id, score, total, attempted, unanswered, wrong, percentage, submitted_at)
    VALUES 
    ($quiz_id, $student_id, $score, $total_questions, $attempted, $unanswered, $wrong, $percentage, NOW())";

if (!mysqli_query($conn, $insert)) {
    die("Error saving result: " . mysqli_error($conn));
}
?>
