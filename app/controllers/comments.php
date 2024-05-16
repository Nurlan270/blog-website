<?php

$article_id = $_GET['id'];
$email = '';
$comment = '';
$comments = [];

// Upload comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uploadComment'])) {
    $email = $_SESSION['email'] ?? trim($_POST['email']);
    $comment = strip_tags(htmlspecialchars(trim($_POST['comment'])));

    $params = [
        'article_id' => $article_id,
        'email' => $email,
        'comment' => $comment
    ];

    insert('comments', $params);

    $users = selectCommentsJoinUsers('comments', 'users', $article_id);
    $comments = selectFromTable('comments', params: ['article_id' => $article_id]);
    $comments_count = countRow('comments', $article_id, 2);


} else {
    $email = null;

    $users = selectCommentsJoinUsers('comments', 'users', $article_id);
    $comments = selectFromTable('comments', params: ['article_id' => $article_id]);
    $comments_count = countRow('comments', $article_id, 2);
}
