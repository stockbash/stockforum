<?php
include 'db.php';
session_start();

$stmt = $pdo->query("SELECT threads.*, users.username FROM threads JOIN users ON threads.user_id = users.id ORDER BY threads.created_at DESC");
$threads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>FORUM</h1><!--change this-->
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Show "Create New Thread" and "Logout" if the user is logged in -->
        <a href="create_thread.php">Create New Thread</a>
        <br>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <!-- Show "Login" link if the user is not logged in -->
        <a href="login.php">Login</a> | <a href="register.php">Register</a>
    <?php endif; ?>

    <ul>
        <?php foreach ($threads as $thread): ?>
            <li>
                <a href="view_thread.php?id=<?= $thread['id'] ?>"><?= $thread['title'] ?></a>
                by <?= $thread['username'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
