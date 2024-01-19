<?php
include 'includes/header.php';

// todo: registration
$errors = [];
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password_repeat'];

    if (!$name || mb_strlen($name) > 100) {
        $errors['name'] = 'Invalid name';
    }

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email';
    }

    $emailExists = $db->prepare('SELECT * FROM users WHERE email = ?');
    $emailExists->execute([$email]);
    d($emailExists);

    if (!$password) {
        $errors['password'] = 'Empty password';
    }

    if ($password !== $passwordRepeat) {
        $errors['password_repeat'] = 'Error password repeat';
    }

    if (count($errors) === 0) {
        $insertQuery = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $insertQuery->execute([
            'name' => $name,
            'email' => $email,
            'password' => md5($password),
        ]);

        header('Location: index.php');
        exit;
    }
}
?>

<h1>Registration</h1>

<form action="registration.php" method="post" novalidate>
    <label>
        Name: <br>
        <input type="text" name="name" value="<?= $name ?? '' ?>">
        <?= $errors['name'] ?? '' ?>
    </label>
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
    <label>
        Password repeat: <br>
        <input type="password" name="password_repeat">
        <?= $errors['password_repeat'] ?? '' ?>
    </label>
    <input type="submit" name="submit" value="Registration">
</form>
