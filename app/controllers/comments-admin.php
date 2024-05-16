<?php

require_once __DIR__ . '/../../app/database/functions.php';

$comments = selectFromTable('comments');

// Get text in edit field
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $comment = selectFromTable('comments', params: ['id' => $_GET['id']])[0];

    $commentText = $comment['comment'];
}

// Edit comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-comment'])) {
    $comment = $_POST['comment'];

    update('comments', ['comment' => $comment], ['id' => $_POST['id']]);

    header('Location: /admin/comments/index.php');
}

// Delete comment
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del'])) {
    delete('comments', ['id' => $_GET['del']]);

    header('Location: /admin/comments/index.php');
}