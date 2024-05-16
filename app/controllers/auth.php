<?php

require_once __DIR__ . '/../database/functions.php';

$errMsg = '';

// Registration validation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-reg'])) {
    // Getting vars
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $passAgain = trim($_POST['passAgain']);

    // Validation
    if (!empty(selectFromTable('users', params: ['login' => $login]))) {
        $errMsg = 'Login is already registered, please type another one.';
    } elseif (!empty(selectFromTable('users', params: ['email' => $email]))) {
        $errMsg = 'Email is already registered, please type another one.';
    } elseif (mb_strlen($login, 'UTF-8') < 5) {
        $errMsg = 'Login can\'t be short than 5 symbols.';
    } elseif (mb_strlen($pass, 'UTF-8') < 5 || mb_strlen($passAgain, 'UTF-8') < 5) {
        $errMsg = 'Password can\'t be short than 6 symbols.';
    } elseif ($pass !== $passAgain) {
        $errMsg = 'Passwords don\'t match, please re-check. ';
    } else
    {   // On success continue and insert data into table

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $params = [
            'login' => $login,
            'email' => $email,
            'password' => $pass
        ];

        insert('users', $params);

        addSessionsContinue($login);
    }

} else {
    $login = '';
    $email = '';
}

// Login validation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-log'])) {
    // Getting vars
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);

    // Validation
    if (empty(selectFromTable('users', params: ['login' => $login]))) {
        $errMsg = 'User with this login not found.';
    } elseif (mb_strlen($login, 'UTF-8') < 5) {
        $errMsg = 'Login can\'t be short than 5 symbols.';
    } elseif (mb_strlen($pass, 'UTF-8') < 5) {
        $errMsg = 'Password can\'t be short than 6 symbols.';
    } elseif (!password_verify($pass, selectFromTable('users', ['password'], 1, ['login' => $login])[0]['password'])) {
        $errMsg = 'Password is invalid.';
    } else
    {
        // On success Log in

        addSessionsContinue($login);
    }

} else {
    $login = '';
}

function addSessionsContinue($login)
{
    $user = selectFromTable('users', limit: 1, params: ['login' => $login]);

    // Setting sessions
    $_SESSION['id'] = $user[0]['id'];
    $_SESSION['email'] = $user[0]['email'];
    $_SESSION['login'] = $user[0]['login'];
    $_SESSION['admin'] = $user[0]['admin'];

    if ($_SESSION['admin']): header('Location: /admin/posts/index.php');
    else: header('Location: /');
    endif;
}