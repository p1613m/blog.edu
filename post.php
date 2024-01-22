<?php
include 'includes/header.php';

$post = $db->prepare('SELECT * FROM posts WHERE id = ?');

$post->execute([$_GET['id'] ?? 0]);
$post = $post->fetch();

if (!$post) {
    redirect('index.php');
}

$postUser = getUser($post['user_id']);
?>

<img src="<?= $post['image_path'] ?>" alt="" style="display:block;width: 500px;">
<h1><?= htmlspecialchars($post['title']) ?></h1>
<p><i><?= $post['created_at'] ?></i></p>
<a href="#"><?= htmlspecialchars($postUser['name']) ?></a>
<p><?= htmlspecialchars($post['content']) ?></p>
