<?php

require_once __DIR__ . '/../../app/database/functions.php';

$search = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search-term'])) {
    $search = trim(htmlspecialchars(strip_tags($_GET['search-term'])));

    if (empty($search)): header('Location: /');
    endif;

    $posts = selectByLikeWhere('posts', $search, ['status' => 1]);
} else {
    $search = null;
}