<?php
include 'includes/core.php';

$data = json_decode(file_get_contents('php://input'), true);

$result = [
    'status' => false,
];

$errors = [];
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

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

        $result['status'] = true;
    } else {
        $errors['email'] = 'Incorrect email or password';
    }
}

$result['errors'] = $errors;

header('Content-Type: application/json');
echo json_encode($result);
