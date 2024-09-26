<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thread_id = $_POST['thread_id'];

    // Fetch the thread to check the user_id
    $stmt = $pdo->prepare("SELECT user_id FROM threads WHERE id = ?");
    $stmt->execute([$thread_id]);
    $thread = $stmt->fetch();

    // Check if the logged-in user is the creator of the thread
    if ($thread && $thread['user_id'] == $_SESSION['user_id']) {
        // Delete the thread
        $stmt = $pdo->prepare("DELETE FROM threads WHERE id = ?");
        $stmt->execute([$thread_id]);
        header('Location: index.php'); // Redirect to index after deletion
        exit();
    } else {
        echo "You do not have permission to delete this thread.";
    }
}
?>