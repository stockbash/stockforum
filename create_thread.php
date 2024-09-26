<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO threads (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $user_id]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Thread</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Create New Thread</h1>

    <form method="POST" action="create_thread.php">
        <input type="text" name="title" placeholder="Thread Title" required><br>
        <textarea name="content" placeholder="Thread Content" rows="5" required></textarea><br>
        <button type="submit">Create Thread</button>
    </form>
</div>

</body>
</html>
