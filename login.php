<?php
include 'includes/header.php';

$errors = [];
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$email) {
        $errors['email'] = 'Field is required';
    }
    if (!$password) {
        $errors['password'] = 'Field is required';
    }

    if (!count($errors)) {
        $user = $db->prepare('SELECT * FROM users WHERE email = ?');
        $user->execute([$email]);

        $user = $user->fetch();
        if ($user && $user['password'] === md5($password)) {
            $_SESSION['user_id'] = $user['id'];

            redirect('index.php');
        } else {
            $errors['email'] = 'Incorrect email or password';
        }
    }
}
?>

<h1>Login</h1>

<form action="login.php" method="post" novalidate>
    <label>
        E-Mail: <br>
        <input type="email" name="email" value="<?= $email ?? '' ?>">
        <?= $errors['email'] ?? '' ?>
    </label>
    <label>
        Password: <br>
        <input type="password" name="password">
        <?= $errors['password'] ?? '' ?>
    </label>
    <input type="submit" name="submit" value="Login">
</form>
