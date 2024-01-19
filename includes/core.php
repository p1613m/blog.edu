<?php

$db = new PDO('mysql:host=localhost;dbname=blog.edu', 'root', 'root');

$query = $db->query('SELECT * FROM users');

function d($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}
