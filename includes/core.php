<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=blog.edu', 'root', 'root');

$query = $db->query('SELECT * FROM users');

function d($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function getUser($id) {
    global $db;

    $user = $db->prepare('SELECT * FROM users WHERE id = ?');
    $user->execute([$id]);

    return $user->fetch();
}

$user = isset($_SESSION['user_id']) ? getUser($_SESSION['user_id']) : false;

if (isset($forAuth) && $forAuth && !$user) {
    redirect('login.php');
}
