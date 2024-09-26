<?php
include 'db.php';
session_start();

$thread_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM threads WHERE id = ?");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch();

$post_stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE thread_id = ? ORDER BY posts.created_at ASC");
$post_stmt->execute([$thread_id]);
$posts = $post_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Thread</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <!-- Back to Last Page Button -->
    <form action="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php' ?>" method="get">
        <button type="submit">Back to Last Page</button>
    </form>

    <h1><?= htmlspecialchars($thread['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($thread['content'])) ?></p>
<!-- Only show delete button if user is the thread creator -->
        <form method="POST" action="delete_thread.php">
            <input type="hidden" name="thread_id" value="<?= $thread_id ?>">
            <button type="submit" onclick="return confirm('Are you sure you want to delete this thread?');">Delete Thread</button>
        </form>

    <ul>
        <?php foreach ($posts as $post): ?>
            <li><?= htmlspecialchars($post['content']) ?> - by <?= htmlspecialchars($post['username']) ?></li>
        <?php endforeach; ?>
    </ul>


    <?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" action="post_reply.php">
        <textarea name="content" placeholder="Reply to this thread" rows="3" required></textarea><br>
        <input type="hidden" name="thread_id" value="<?= $thread_id ?>">
        <button type="submit">Post Reply</button>
    </form>

    <?php if ($_SESSION['user_id'] == $thread['user_id']): ?>
        
    <?php endif; ?>
    
    <?php else: ?>
    <p>Please <a href="login.php">login</a> to post a reply.</p>
    <?php endif; ?>
</div>

</body>
</html>
