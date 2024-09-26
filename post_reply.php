
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $thread_id = $_POST['thread_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (thread_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$thread_id, $user_id, $content]);

    header("Location: view_thread.php?id=" . $thread_id);
    exit();
}
?>
