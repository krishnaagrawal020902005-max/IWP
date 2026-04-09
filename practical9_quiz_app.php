<?php
/*
=================================================
  PRACTICAL 9 — QUIZ APP WITH PHP + MYSQL
  Setup: Run the SQL below in phpMyAdmin first.

  SQL:
  CREATE DATABASE quizdb;
  USE quizdb;
  CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL,
    category VARCHAR(100) DEFAULT 'General'
  );

  INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_option, category) VALUES
  ('What does HTML stand for?', 'HyperText Markup Language', 'High Text Machine Language', 'Hyperlink Markup Language', 'Home Tool Markup Language', 'A', 'Web'),
  ('Which tag is used for the largest heading?', '<h6>', '<h1>', '<head>', '<header>', 'B', 'Web'),
  ('Which protocol is used to transfer web pages?', 'FTP', 'SMTP', 'HTTP', 'SSH', 'C', 'Networking'),
  ('CSS stands for?', 'Creative Style Syntax', 'Cascading Style Sheets', 'Computer Style System', 'Coded Style Script', 'B', 'Web'),
  ('Which JavaScript method removes the last element from an array?', 'pop()', 'shift()', 'splice()', 'remove()', 'A', 'JavaScript'),
  ('What is the correct PHP opening tag?', '<?>', '<php>', '<?php', '<script php>', 'C', 'PHP'),
  ('Which SQL command retrieves data?', 'INSERT', 'UPDATE', 'SELECT', 'DELETE', 'C', 'Database'),
  ('Which tag is used to create a hyperlink in HTML?', '<link>', '<a>', '<href>', '<url>', 'B', 'Web'),
  ('What does DOM stand for?', 'Document Object Model', 'Data Object Method', 'Display Output Module', 'Document Order Model', 'A', 'Web'),
  ('Which HTTP method is used to send form data in the request body?', 'GET', 'HEAD', 'POST', 'DELETE', 'C', 'Networking');
=================================================
*/

session_start();

// DB CONFIG — update these
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'quizdb';

$page = $_GET['page'] ?? 'quiz';

// DB connect
$conn = null;
$db_error = '';
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $db_error = $e->getMessage();
}

// Reset quiz
if (isset($_GET['reset'])) {
    $_SESSION = [];
    header('Location: practical9_quiz_app.php');
    exit;
}

// Init session
if (!isset($_SESSION['quiz_started'])) {
    $_SESSION['quiz_started'] = false;
    $_SESSION['current_q'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['score'] = 0;
    $_SESSION['start_time'] = null;
    $_SESSION['questions'] = [];
}

// Load questions from DB
if ($conn && empty($_SESSION['questions'])) {
    $stmt = $conn->query("SELECT * FROM questions ORDER BY RAND() LIMIT 10");
    $_SESSION['questions'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$questions = $_SESSION['questions'];
$total = count($questions);

// Handle answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $q_index = (int)$_POST['q_index'];
    $answer = $_POST['answer'];
    if ($q_index < $total) {
        $_SESSION['answers'][$q_index] = $answer;
        if ($answer === $questions[$q_index]['correct_option']) {
            $_SESSION['score']++;
        }
        $_SESSION['current_q'] = $q_index + 1;
    }
    header('Location: practical9_quiz_app.php');
    exit;
}

// Start quiz
if (isset($_POST['start'])) {
    $_SESSION['quiz_started'] = true;
    $_SESSION['start_time'] = time();
    header('Location: practical9_quiz_app.php');
    exit;
}

$current = $_SESSION['current_q'];
$score = $_SESSION['score'];
$quiz_done = $current >= $total && $_SESSION['quiz_started'];
$percent = $total > 0 ? round(($score / $total) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>QuizZone — Web Tech Quiz</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Syne+Mono&display=swap');
    :root {
      --bg:#fafafa; --card:#fff; --primary:#ff6b35;
      --text:#111; --muted:#888; --border:#e8e8e8;
      --shadow:0 4px 24px rgba(0,0,0,0.08);
      --correct:#16a34a; --wrong:#dc2626;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:var(--bg); color:var(--text); font-family:'Syne',sans-serif; min-height:100vh; display:flex; flex-direction:column; }
    header {
      background:var(--primary); color:#fff; padding:18px 40px;
      display:flex; justify-content:space-between; align-items:center;
    }
    header h1 { font-size:1.6rem; font-weight:800; letter-spacing:2px; }
    header .info { font-size:0.8rem; opacity:.8; }
    .container { max-width:760px; margin:0 auto; padding:40px 20px; flex:1; width:100%; }

    /* DB ERROR */
    .db-error {
      background:#fff5f5; border:1px solid #fecaca; border-radius:10px; padding:24px;
      color:#dc2626; font-size:0.9rem; line-height:1.7; margin-bottom:24px;
    }
    .db-error code { font-family:'Syne Mono'; font-size:0.8rem; display:block; margin-top:8px; opacity:.7; }

    /* START */
    .start-card {
      background:var(--card); border-radius:16px; box-shadow:var(--shadow);
      padding:60px 50px; text-align:center;
    }
    .start-icon { font-size:4rem; margin-bottom:20px; }
    .start-card h2 { font-size:2rem; font-weight:800; margin-bottom:10px; }
    .start-card p { color:var(--muted); margin-bottom:6px; font-size:0.95rem; }
    .badges { display:flex; gap:10px; justify-content:center; margin:20px 0 30px; flex-wrap:wrap; }
    .badge { padding:6px 16px; border-radius:100px; font-size:0.75rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; }
    .badge-orange { background:#fff0eb; color:var(--primary); }
    .badge-blue { background:#eff6ff; color:#2563eb; }

    /* QUIZ */
    .progress-info {
      display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;
    }
    .progress-info span { font-size:0.8rem; color:var(--muted); font-weight:600; }
    .progress-track { background:var(--border); border-radius:100px; height:6px; margin-bottom:30px; }
    .progress-fill {
      background:var(--primary); height:6px; border-radius:100px; transition:width .4s;
    }
    .q-card { background:var(--card); border-radius:16px; box-shadow:var(--shadow); padding:40px; }
    .q-number { font-size:0.7rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--primary); margin-bottom:14px; }
    .q-category { display:inline-block; background:#fff0eb; color:var(--primary); font-size:0.65rem; padding:3px 10px; border-radius:100px; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:14px; }
    .q-text { font-size:1.2rem; font-weight:700; line-height:1.5; margin-bottom:28px; }
    .options { display:flex; flex-direction:column; gap:12px; }
    .option-label {
      display:flex; align-items:center; gap:14px;
      padding:14px 18px; border:2px solid var(--border); border-radius:10px;
      cursor:pointer; transition:all .2s; user-select:none;
    }
    .option-label:hover { border-color:var(--primary); background:#fff5f2; }
    .option-label input { display:none; }
    .option-label input:checked + .option-key { background:var(--primary); color:#fff; border-color:var(--primary); }
    .option-label:has(input:checked) { border-color:var(--primary); background:#fff5f2; }
    .option-key {
      width:32px; height:32px; border-radius:8px; border:2px solid var(--border);
      display:flex; align-items:center; justify-content:center;
      font-size:0.8rem; font-weight:700; flex-shrink:0; transition:all .2s;
    }
    .option-text { font-size:0.95rem; font-weight:500; }
    .submit-btn {
      width:100%; background:var(--primary); color:#fff; border:none;
      padding:14px; border-radius:10px; font-family:'Syne',sans-serif;
      font-size:1rem; font-weight:700; cursor:pointer; margin-top:24px;
      transition:opacity .2s;
    }
    .submit-btn:hover { opacity:.9; }

    /* RESULTS */
    .result-card { background:var(--card); border-radius:16px; box-shadow:var(--shadow); padding:40px; }
    .score-ring {
      width:140px; height:140px; margin:0 auto 24px;
      display:flex; align-items:center; justify-content:center;
      border-radius:50%; font-size:2.5rem; font-weight:800;
      position:relative;
    }
    .score-ring::before {
      content:''; position:absolute; inset:0; border-radius:50%;
      background:conic-gradient(var(--primary) var(--pct), var(--border) var(--pct));
    }
    .score-ring .inner {
      width:110px; height:110px; background:var(--card); border-radius:50%;
      display:flex; flex-direction:column; align-items:center; justify-content:center;
      position:relative; z-index:1;
    }
    .score-ring .inner .num { font-size:1.8rem; font-weight:800; color:var(--primary); }
    .score-ring .inner .den { font-size:0.8rem; color:var(--muted); }
    .result-card h2 { text-align:center; font-size:1.6rem; font-weight:800; margin-bottom:6px; }
    .result-card .tagline { text-align:center; color:var(--muted); margin-bottom:28px; }

    .q-review { border-top:1px solid var(--border); margin-top:24px; padding-top:24px; }
    .q-review h3 { font-size:0.75rem; letter-spacing:2px; text-transform:uppercase; color:var(--muted); margin-bottom:16px; }
    .review-item {
      padding:14px 16px; border-radius:8px; margin-bottom:10px; border:1px solid;
    }
    .review-item.correct { background:#f0fdf4; border-color:#bbf7d0; }
    .review-item.wrong { background:#fff1f2; border-color:#fecdd3; }
    .ri-q { font-size:0.85rem; font-weight:600; margin-bottom:6px; }
    .ri-meta { font-size:0.75rem; display:flex; gap:16px; }
    .ri-meta span { font-weight:600; }
    .correct-ans { color:var(--correct); }
    .wrong-ans { color:var(--wrong); }

    .btn { padding:12px 28px; border-radius:10px; font-family:'Syne',sans-serif; font-size:0.9rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
    .btn-primary { background:var(--primary); color:#fff; }
    .btn-outline { background:transparent; border:2px solid var(--border); color:var(--muted); }
  </style>
</head>
<body>
<header>
  <h1>⚡ QUIZZONE</h1>
  <div class="info">Web Technology Practice Quiz</div>
</header>
<div class="container">

<?php if ($db_error): ?>
<div class="db-error">
  <strong>Database connection error.</strong> Please check your credentials and ensure the database is set up.<br/>
  Run the SQL at the top of this file in phpMyAdmin to create tables and insert questions.
  <code><?= htmlspecialchars($db_error) ?></code>
</div>
<?php endif; ?>

<?php if (!$_SESSION['quiz_started']): ?>
<!-- START SCREEN -->
<div class="start-card">
  <div class="start-icon">🧠</div>
  <h2>Web Technology Quiz</h2>
  <p>Test your knowledge of HTML, CSS, JavaScript, PHP, and more.</p>
  <div class="badges">
    <span class="badge badge-orange"><?= $total ?> Questions</span>
    <span class="badge badge-blue">Multiple Choice</span>
    <span class="badge badge-orange">Instant Results</span>
  </div>
  <form method="POST">
    <button type="submit" name="start" class="submit-btn" style="max-width:220px">Start Quiz →</button>
  </form>
</div>

<?php elseif ($quiz_done): ?>
<!-- RESULTS -->
<div class="result-card">
  <div class="score-ring" style="--pct:<?= $percent ?>%">
    <div class="inner">
      <div class="num"><?= $score ?></div>
      <div class="den">/ <?= $total ?></div>
    </div>
  </div>
  <h2><?= $percent >= 80 ? '🎉 Excellent!' : ($percent >= 60 ? '👍 Good Job!' : '📚 Keep Practising') ?></h2>
  <p class="tagline">You scored <?= $percent ?>% — <?= $score ?> correct out of <?= $total ?> questions.</p>

  <div style="display:flex;gap:12px;justify-content:center;margin-bottom:24px">
    <a href="?reset=1"><button class="btn btn-primary">Retry Quiz</button></a>
  </div>

  <div class="q-review">
    <h3>Question Review</h3>
    <?php foreach ($questions as $i => $q):
      $given = $_SESSION['answers'][$i] ?? null;
      $is_correct = $given === $q['correct_option'];
      $opt_map = ['A'=>$q['option_a'],'B'=>$q['option_b'],'C'=>$q['option_c'],'D'=>$q['option_d']];
    ?>
    <div class="review-item <?= $is_correct?'correct':'wrong' ?>">
      <div class="ri-q"><?= $i+1 ?>. <?= htmlspecialchars($q['question']) ?></div>
      <div class="ri-meta">
        <span>Your answer: <span class="<?= $is_correct?'correct-ans':'wrong-ans' ?>"><?= $given ? $opt_map[$given] : 'Skipped' ?></span></span>
        <?php if(!$is_correct): ?><span>Correct: <span class="correct-ans"><?= $opt_map[$q['correct_option']] ?></span></span><?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php else: ?>
<!-- QUIZ QUESTION -->
<?php $q = $questions[$current]; ?>
<div class="progress-info">
  <span>Question <?= $current+1 ?> of <?= $total ?></span>
  <span>Score: <?= $score ?></span>
</div>
<div class="progress-track">
  <div class="progress-fill" style="width:<?= round(($current/$total)*100) ?>%"></div>
</div>
<div class="q-card">
  <div class="q-category"><?= htmlspecialchars($q['category']) ?></div>
  <div class="q-number">Question <?= $current+1 ?></div>
  <div class="q-text"><?= htmlspecialchars($q['question']) ?></div>
  <form method="POST">
    <input type="hidden" name="q_index" value="<?= $current ?>"/>
    <div class="options">
      <?php foreach (['A','B','C','D'] as $opt):
        $key = 'option_' . strtolower($opt); ?>
      <label class="option-label">
        <input type="radio" name="answer" value="<?= $opt ?>" required/>
        <div class="option-key"><?= $opt ?></div>
        <div class="option-text"><?= htmlspecialchars($q[$key]) ?></div>
      </label>
      <?php endforeach; ?>
    </div>
    <button type="submit" class="submit-btn"><?= $current+1 < $total ? 'Next Question →' : 'Submit Quiz ✓' ?></button>
  </form>
</div>
<?php endif; ?>

</div>
</body>
</html>
