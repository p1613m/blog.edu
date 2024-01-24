<?php
$forAuth = true;
include 'includes/header.php';

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
    if (!$image['size']) {
        $errors['image'] = 'Field is required';
    }

    if (!count($errors)) {
        $imagePath = 'uploads/' . md5(time() . ' ' . rand(10000, 999999)) . '.' . $acceptMimes[$image['type']];

        move_uploaded_file($image['tmp_name'], $imagePath);

        $preparedPost = $db->prepare('INSERT INTO posts (user_id, title, content, image_path, created_at) VALUES (:user_id, :title, :content, :image_path, NOW())');
        $preparedPost->execute([
            'user_id' => $user['id'],
            'title' => $title,
            'content' => $content,
            'image_path' => $imagePath,
        ]);

        redirect('index.php');
    }
}
?>

<h1>Create post</h1>

<form action="create.php" method="post" novalidate enctype="multipart/form-data">
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
        <input type="file" name="image">
        <?= $errors['image'] ?? '' ?>
    </label>

    <input type="submit" name="submit" value="Create">
</form>
