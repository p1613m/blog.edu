<?php
include 'core.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: sans-serif;
            font-size: 18px;
            margin: 10px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"],
        textarea,
        input[type="email"] {
            padding: 10px;
            display: block;
            width: 400px;
        }
        input[type="submit"] {
            display: block;
            padding: 5px 10px;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Главная</a>
    <?php if (!$user): ?>
        <a href="login.php">Вход</a>
        <a href="registration.php">Регистрация</a>
    <?php else: ?>
        <a href="create.php">Создать пост</a>
        <a href="logout.php">Выход</a>
    <?php endif; ?>
</nav>
