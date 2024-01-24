<?php
$forAuth = true;
include 'includes/header.php';

$post = getPost($_GET['id'] ?? 0);

if (!$post || $user['id'] != $post['user_id']) {
    redirect('index.php');
}

$title = $post['title'];
$content = $post['content'];

$errors = [];
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = $_FILES['image'];

    if (!$title || mb_strlen($title) > 100) {
        $errors['title'] = 'Incorrect title';
    }
    if (!$content || mb_strlen($content) > 10000) {
        $errors['content'] = 'Incorrect content';
    }

    if ($image['size']) {
        $acceptMimes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
        ];
        if ($image['size'] > 5 * 1024 * 1024) {
            $errors['image'] = 'Max 5 MB';
        }
        if (!isset($acceptMimes[$image['type']])) {
            $errors['image'] = 'Incorrect type';
        }
    }

    if (!count($errors)) {
        $imagePath = $post['image_path'];
        if ($image['size']) {
            $imagePath = 'uploads/' . md5(time() . ' ' . rand(10000, 999999)) . '.' . $acceptMimes[$image['type']];

            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $preparedPost = $db->prepare('UPDATE posts SET title = :title, content = :content, image_path = :image_path WHERE id = :id');
        $preparedPost->execute([
            'id' => $post['id'],
            'title' => $title,
            'content' => $content,
            'image_path' => $imagePath,
        ]);

        redirect('post.php?id=' . $post['id']);
    }
}
?>

<h1>Edit post</h1>

<form action="edit.php?id=<?= $post['id'] ?>" method="post" novalidate enctype="multipart/form-data">
    <label>
        Title: <br>
        <input type="text" name="title" value="<?= $title ?? '' ?>">
        <?= $errors['title'] ?? '' ?>
    </label>
    <label>
        Content: <br>
        <textarea name="content"><?= $content ?? '' ?></textarea>
        <?= $errors['content'] ?? '' ?>
    </label>
    <label>
        Image: <br>
        <img src="<?= $post['image_path'] ?>" alt="" style="width: 200px;display:block;">
        <input type="file" name="image">
        <?= $errors['image'] ?? '' ?>
    </label>

    <input type="submit" name="submit" value="Edit">
</form>
