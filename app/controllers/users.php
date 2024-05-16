<?php

require_once __DIR__ . '/../../app/database/functions.php';

$msg = [];

// Create user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-btn'])) {
    // Getting vars
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $passAgain = trim($_POST['passAgain']);
    $role = $_POST['role'];

    // Validation
    if (!empty(selectFromTable('users', params: ['login' => $login]))) {
        $msg[] = 'Login is already registered, please type another one.';
    } elseif (!empty(selectFromTable('users', params: ['email' => $email]))) {
        $msg[] = 'Email is already registered, please type another one.';
    } elseif (mb_strlen($login, 'UTF-8') < 5) {
        $msg[] = 'Login can\'t be short than 5 symbols.';
    } elseif (mb_strlen($pass, 'UTF-8') < 5 || mb_strlen($passAgain, 'UTF-8') < 5) {
        $msg[] = 'Password can\'t be short than 6 symbols.';
    } elseif ($pass !== $passAgain) {
        $msg[] = 'Passwords don\'t match, please re-check. ';
    } else
    {   // On success continue and insert data into table

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $params = [
            'login' => $login,
            'email' => $email,
            'password' => $pass,
            'admin' => empty($role) ? 0 : 1
        ];

        insert('users', $params);

        header('Location: /admin/users/index.php');
    }

} else {
    $login = null;
    $email = null;
}

// Edit user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Vars
    $user = selectFromTable('users', limit: 1, params: ['id' => $_GET['id']])[0];
    $id = $_GET['id'];
    $admin = $user['admin'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-btn'])) {
    // Getting vars
    $user = selectFromTable('users', ['login', 'email', 'password', 'admin'],  1, ['id' => $_POST['id']])[0];
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $role = empty($_POST['role']) ? 0 : 1;

    // Validation
    if (mb_strlen($login, 'UTF-8') < 5) {
        $msg[] = 'Login can\'t be short than 5 symbols.';
    } elseif (mb_strlen($pass, 'UTF-8') < 5) {
        $msg[] = 'Password can\'t be short than 6 symbols.';
    }

    if (!empty($msg)): return;
    endif;

    // On success continue and insert data into table

    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $params = [
        'login' => $login,
        'email' => $email,
        'password' => $pass,
        'admin' => $role
    ];

    update('users', $params, ['id' => $_POST['id']]); //!!! USE POST NOT GET IT CAUSE ERROR AND ADD HIDDEN ID INPUT IN EDIT.PHP

    header('Location: /admin/users/index.php');

} else {
    $login = '';
    $email = '';
}

// Delete user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    delete('users', ['id' => $_GET['del_id']]);

    header('Location: /admin/users/index.php');
}