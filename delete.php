<?php
include 'includes/core.php';

$post = getPost($_GET['id'] ?? 0);

if ($post && $user && $user['id'] == $post['user_id']) {
    $deletePrepare = $db->prepare('DELETE FROM posts WHERE id = ?');
    $deletePrepare->execute([$_GET['id']]);
}

redirect('index.php');
