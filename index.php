<?php
include 'includes/header.php';

$page = (int) ($_GET['page'] ?? 1);
$perPage = 3;
$offset = ($page - 1) * $perPage;

$posts = $db->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT ' . $perPage . ' OFFSET ' . $offset)->fetchAll();

if ($page > 1 && count($posts) === 0) {
    redirect('index.php');
}
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

<ul>
    <?php
    $countPosts = $db->query('SELECT count(*) AS count FROM posts')->fetch()['count'];
    $countPages = ceil($countPosts / $perPage);
    ?>

    <?php for ($i = 1; $i <= $countPages; $i++): ?>
        <li><a href="index.php?page=<?= $i ?>"
                <?php if ($i === $page): ?>
                    style="font-weight: bold;"
                <?php endif; ?>
            ><?= $i ?></a></li>
    <?php endfor; ?>
</ul>

<?php
include 'includes/footer.php';
