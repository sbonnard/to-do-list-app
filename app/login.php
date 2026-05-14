<?php
session_start();

require_once 'includes/_config.php';
require_once 'includes/_functions.php';
require_once 'includes/_database.php';
require_once 'includes/_messages.php';

// header('Content-type:application/json');


if (!isset($_POST['action'])) {
    triggerError('no_action');
}

// Check CSRF
preventFromCSRF('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'log-in') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $dbCo->prepare('SELECT * FROM users WHERE username = :username');
    $query->execute(['username' => $username]);
    $user = $query->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
        
        $queryLastConnection = $dbCo->prepare('UPDATE users SET lastConnection = Now() WHERE id_user = :id_user');
        $bindValues = [
            "id_user" => $_SESSION['id_user']
            ];
        $queryLastConnection->execute($bindValues);
        
        redirectTo();
        exit();
    } else {
        addError('login_fail');
        redirectTo('index.php');
    }
}
