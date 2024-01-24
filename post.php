<?php
include 'includes/header.php';

$post = getPost($_GET['id'] ?? 0);

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

<?php if ($user && $user['id'] == $post['user_id']): ?>
    <br>
    <p>
        <a href="delete.php?id=<?= $post['id'] ?>">Удалить</a> |
        <a href="edit.php?id=<?= $post['id'] ?>">Редактировать</a>
    </p>
<?php endif; ?>
