<?php
include 'includes/header.php';
$posts = $db->query('SELECT * FROM posts ORDER BY created_at DESC')->fetchAll();
?>

<?php foreach ($posts as $post):
    $postUser = getUser($post['user_id']);
    ?>

    <hr>
    <article>
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p><i><?= $post['created_at'] ?></i></p>
        <a href="#"><?= htmlspecialchars($postUser['name']) ?></a>
        <img src="<?= $post['image_path'] ?>" alt="" style="display:block;width: 350px;">
        <a href="post.php?id=<?= $post['id'] ?>">Read all</a>
    </article>

<?php endforeach; ?>

<?php
include 'includes/footer.php';
