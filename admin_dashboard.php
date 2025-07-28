<?php
session_start();
include("includes/db.php");

// Redirect if not logged in
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .tab-content > .tab-pane:not(.active) {
      display: none;
    }
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
    }
    .container {
  background: rgba(255, 255, 255, 0.85);
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  animation: fadeInUp 1s ease-out;
  max-height: 90vh;
  overflow-y: auto;
}

.nav-tabs .nav-link {
  color: #0d6efd;
  font-weight: 500;
}

.nav-tabs .nav-link.active {
  background-color: #fff;
  border-color: #dee2e6 #dee2e6 #fff;
  font-weight: bold;
}

label {
  font-weight: 500;
}

.alert {
  animation: fadeInUp 0.5s ease-out;
}

  </style>
</head>
<body class="bg-light">
  <div class="container-fluid py-2 mt-4 mr-5 d-flex justify-content-end">
  <a href="admin.php" class="btn btn-danger">Logout</a>
</div>
<div class="container py-4">

  <ul class="nav nav-tabs mb-4" id="adminTabs">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#createQuiz">Create Quiz</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addQuestions">Add Questions</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#updateQuestions">Update Questions</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dashboard">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#manageQuizzes">Manage Quizzes</a></li>
  </ul>

  <div class="tab-content">
    <!-- Create Quiz Tab -->
    <div class="tab-pane active" id="createQuiz">
      <?php
      if (isset($_POST['create_quiz'])) {
          $title = mysqli_real_escape_string($conn, $_POST["title"]);
          $desc = mysqli_real_escape_string($conn, $_POST["description"]);
          $limit = (int) $_POST["time_limit"];
          $qcount = (int) $_POST["num_questions"];

          $conn->query("INSERT INTO quizzes (title, description, time_limit) VALUES ('$title', '$desc', '$limit')");
          $quiz_id = mysqli_insert_id($conn);
          $_SESSION['quiz_id'] = $quiz_id;
          $_SESSION['num_questions'] = $qcount;

          echo "<div class='alert alert-success'>Quiz created. Now add $qcount questions.</div>";
      }
      ?>
      <form method="POST">
        <div class="mb-3">
          <label>Quiz Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label>Time Limit (in minutes)</label>
          <input type="number" name="time_limit" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Number of Questions</label>
          <input type="number" name="num_questions" class="form-control" required>
        </div>
        <button type="submit" name="create_quiz" class="btn btn-primary">Create Quiz</button>
      </form>
    </div>

    <!-- Add Questions Tab -->
    <div class="tab-pane" id="addQuestions">
      <?php
      if (isset($_SESSION['quiz_id']) && isset($_SESSION['num_questions'])):
      ?>
      <form method="POST">
        <?php for ($i = 1; $i <= $_SESSION['num_questions']; $i++): ?>
          <h5 class="mt-4">Question <?= $i ?></h5>
          <div class="mb-3">
            <label>Question Text</label>
            <textarea name="question_text[]" class="form-control" required></textarea>
          </div>
          <div class="row mb-3">
            <div class="col"><input type="text" name="option_a[]" class="form-control" placeholder="Option A" required></div>
            <div class="col"><input type="text" name="option_b[]" class="form-control" placeholder="Option B" required></div>
          </div>
          <div class="row mb-3">
            <div class="col"><input type="text" name="option_c[]" class="form-control" placeholder="Option C" required></div>
            <div class="col"><input type="text" name="option_d[]" class="form-control" placeholder="Option D" required></div>
          </div>
          <div class="mb-3">
            <label>Correct Option</label>
            <select name="correct_option[]" class="form-select" required>
              <option>A</option><option>B</option><option>C</option><option>D</option>
            </select>
          </div>
          <hr>
        <?php endfor; ?>
        <button type="submit" name="submit_questions" class="btn btn-success">Save All Questions</button>
      </form>

      <?php
      if (isset($_POST['submit_questions'])) {
        $quiz_id = $_SESSION['quiz_id'];
        for ($i = 0; $i < $_SESSION['num_questions']; $i++) {
          $q = mysqli_real_escape_string($conn, $_POST['question_text'][$i]);
          $a = mysqli_real_escape_string($conn, $_POST['option_a'][$i]);
          $b = mysqli_real_escape_string($conn, $_POST['option_b'][$i]);
          $c = mysqli_real_escape_string($conn, $_POST['option_c'][$i]);
          $d = mysqli_real_escape_string($conn, $_POST['option_d'][$i]);
          $correct = $_POST['correct_option'][$i];

          $conn->query("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option)
                        VALUES ('$quiz_id', '$q', '$a', '$b', '$c', '$d', '$correct')");
        }
        echo "<div class='alert alert-success mt-3'>Questions saved!</div>";
        unset($_SESSION['quiz_id']);
        unset($_SESSION['num_questions']);
      }
      ?>
      <?php else: ?>
        <div class="alert alert-warning">Please create a quiz first.</div>
      <?php endif; ?>
    </div>

    <!-- Update Questions Tab -->
    <div class="tab-pane" id="updateQuestions">
      <form method="GET">
        <label>Select Quiz to Edit</label>
        <select name="edit_quiz_id" class="form-select mb-3" onchange="this.form.submit()">
          <option value="">-- Select Quiz --</option>
          <?php
          $qz = mysqli_query($conn, "SELECT * FROM quizzes");
          while($q = mysqli_fetch_assoc($qz)) {
            $sel = (isset($_GET['edit_quiz_id']) && $_GET['edit_quiz_id'] == $q['id']) ? "selected" : "";
            echo "<option value='{$q['id']}' $sel>{$q['title']}</option>";
          }
          ?>
        </select>
      </form>
      <?php
      if (isset($_GET['edit_quiz_id'])) {
        $quiz_id = $_GET['edit_quiz_id'];
        $questions = mysqli_query($conn, "SELECT * FROM questions WHERE quiz_id = $quiz_id");

        while($q = mysqli_fetch_assoc($questions)):
      ?>
        <form method="POST">
          <input type="hidden" name="qid" value="<?= $q['id'] ?>">
          <textarea name="question_text" class="form-control mb-2"><?= $q['question_text'] ?></textarea>
          <input name="option_a" value="<?= $q['option_a'] ?>" class="form-control mb-2">
          <input name="option_b" value="<?= $q['option_b'] ?>" class="form-control mb-2">
          <input name="option_c" value="<?= $q['option_c'] ?>" class="form-control mb-2">
          <input name="option_d" value="<?= $q['option_d'] ?>" class="form-control mb-2">
          <select name="correct_option" class="form-select mb-3">
            <?php foreach (['A','B','C','D'] as $opt): ?>
              <option <?= $q['correct_option'] == $opt ? 'selected' : '' ?>><?= $opt ?></option>
            <?php endforeach; ?>
          </select>
          <button name="update_question" class="btn btn-warning mb-4">Update</button>
        </form>
      <?php endwhile; } ?>

      <?php
      if (isset($_POST['update_question'])) {
        $qid = $_POST['qid'];
        $q = mysqli_real_escape_string($conn, $_POST['question_text']);
        $a = mysqli_real_escape_string($conn, $_POST['option_a']);
        $b = mysqli_real_escape_string($conn, $_POST['option_b']);
        $c = mysqli_real_escape_string($conn, $_POST['option_c']);
        $d = mysqli_real_escape_string($conn, $_POST['option_d']);
        $correct = $_POST['correct_option'];
        mysqli_query($conn, "UPDATE questions SET question_text='$q', option_a='$a', option_b='$b', option_c='$c', option_d='$d', correct_option='$correct' WHERE id=$qid");
        echo "<div class='alert alert-info'>Question Updated</div>";
      }
      ?>
    </div>

    <!-- Dashboard Tab -->
    <div class="tab-pane" id="dashboard">
      <div class="card-header">Result Board</div>
        <div class="card-body">
          <form method="GET">
            <label>Select Quiz</label>
            <select name="quiz_result_id" class="form-select mb-3" onchange="this.form.submit()">
            <option value="">-- Select Quiz --</option>
            <?php
            $qz = mysqli_query($conn, "SELECT * FROM quizzes");
            while($q = mysqli_fetch_assoc($qz)) {
            $selected = (isset($_GET['quiz_result_id']) && $_GET['quiz_result_id'] == $q['id']) ? 'selected' : '';
            echo "<option value='{$q['id']}' $selected>{$q['title']}</option>";
            }
            ?>
            </select>
          </form>

          <?php
            if (isset($_GET['quiz_result_id'])) {
            $quizId = $_GET['quiz_result_id'];

            $resQuery = "SELECT r.*, s.name, s.reg_no, s.department FROM results r 
                   JOIN students s ON r.student_id = s.id 
                   WHERE r.quiz_id = $quizId ORDER BY r.percentage DESC";

            $resResult = mysqli_query($conn, $resQuery);
          ?>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
              <th>Name</th>
              <th>Register No</th>
              <th>Department</th>
              <th>Max Marks</th>
              <th>Marks Scored</th>
              <th>Unanswered</th>
              <th>Wrong</th>
              <th>Percentage</th>
            </tr>
          </thead>
          <tbody>
          <?php while($row = mysqli_fetch_assoc($resResult)): ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['reg_no']) ?></td>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= $row['total'] ?></td>
            <td><?= $row['score'] ?></td>
            <td><?= $row['unanswered'] ?></td>
            <td><?= $row['wrong'] ?></td>
            <td><?= $row['percentage'] ?>%</td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php } ?>
  </div>
  </div>

  <div class="tab-pane" id="manageQuizzes">
    <h4 class="mb-3">Manage Quizzes</h4>

    <?php
     if (isset($_POST['start_quiz'])) {
        $id = $_POST['quiz_id'];
        mysqli_query($conn, "UPDATE quizzes SET status='active' WHERE id=$id");
    }

  if (isset($_POST['stop_quiz'])) {
      $id = $_POST['quiz_id'];
      mysqli_query($conn, "UPDATE quizzes SET status='inactive' WHERE id=$id");
  }

  if (isset($_POST['delete_quiz'])) {
      $id = $_POST['quiz_id'];
      mysqli_query($conn, "DELETE FROM quizzes WHERE id=$id");
      mysqli_query($conn, "DELETE FROM questions WHERE quiz_id=$id"); // optional: delete questions too
      mysqli_query($conn, "DELETE FROM results WHERE quiz_id=$id");   // optional: delete results too
  }

  $all_quizzes = mysqli_query($conn, "SELECT * FROM quizzes");
  ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($quiz = mysqli_fetch_assoc($all_quizzes)): ?>
        <tr>
          <td><?= htmlspecialchars($quiz['title']) ?></td>
          <td><?= htmlspecialchars($quiz['description']) ?></td>
          <td><?= $quiz['status'] == 'active' ? "<span class='text-success fw-bold'>Active</span>" : "<span class='text-secondary'>Inactive</span>" ?></td>
          <td>
            <form method="POST" class="d-inline">
              <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
              <?php if ($quiz['status'] == 'inactive'): ?>
                <button name="start_quiz" class="btn btn-success btn-sm">Start</button>
              <?php else: ?>
                <button name="stop_quiz" class="btn btn-warning btn-sm">Stop</button>
              <?php endif; ?>
            </form>
            <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
              <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
              <button name="delete_quiz" class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>