<?php

require_once __DIR__ . '/../database/functions.php';

$title = null;
$content = null;
$img = null;
$msg = [];
$posts = selectAllFromPostsWithUsers('posts', 'users');

// Create post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-post'])) {

    $title = strip_tags(htmlspecialchars(trim($_POST['title'])));
    $content = strip_tags(htmlspecialchars(trim($_POST['content'])));
    $topic = trim($_POST['topic']);
    $publish = $_POST['publish'] ?? 0;

    if (!empty($_FILES['img']['name'])) {
        // Vars
        $imgName = time() . '_' . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $fileSize = $_FILES['img']['size'];
        $dimensions = getimagesize($fileTmpName);
        $width = $dimensions[0];
        $height = $dimensions[1];
        $destination = __DIR__ . '/../../assets/img/posts/' . $imgName;

        if (!in_array(strstr($fileType, '/'), ['/jpg', '/jpeg', '/png'])) {
            $msg[] = "Error: Only [ 'jpg', 'jpeg', 'png' ] - formats allowed here, your file format is: " . strstr($fileType, '/'); return;
        } elseif ($fileSize > 1048576 * 5) {
            $msg[] = 'Error: Your image is big. Maximum file size is 5 MB - your file size is: ' . (float)sprintf('%.2f', ($fileSize / 1048576)) . ' MB';
        } elseif ($width > 1000 || $height > 600) {
            $msg[] = 'Error: Image resolution maximum is 1000x900, your image resolution: ' . $width . 'x' . $height;
        }

        if (!empty($msg)): return;
        endif;

        $result = move_uploaded_file($fileTmpName, $destination);

        if (!$result): $msg[] = "Error: Unknown error while uploading your image to server";
        else: $img = $imgName;
        endif;

    } else {
        $msg[] = "Error: Please choose image for your post";
    }

    if (mb_strlen($title, 'UTF-8') < 3): $msg[] = 'Error: Title can\'t be shorter than 3 characters';
    elseif (mb_strlen($content, 'UTF-8') < 10): $msg[] = 'Error: Content can\'t be shorter than 10 characters';
    elseif (mb_strlen($title, 'UTF-8') > 35): $msg[] = 'Error: Title can\'t be longer than 35 characters';
    elseif ($topic == 0): $msg[] = 'Error: Please choose topic';
    endif;

    if (!empty($msg)): return;
    endif;

    $params = [
        'id_user' => $_SESSION['id'],
        'id_topic' => $topic,
        'title' => $title,
        'content' => $content,
        'img' => $img,
        'status' => $publish
    ];

    insert('posts', $params);

    header('Location: /admin/posts/index.php');
} else {
    $id = null;
    $title = null;
    $content = null;
    $img = null;
}

// Edit post
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Vars
    $post = selectFromTable('posts', limit: 1, params: ['id' => $_GET['id']])[0];
    $views = selectFromTable('posts', ['views'], params: ['id' => $_GET['id']])[0]['views'];
    update('posts', ['views' => ($views)+1], ['id' => $_GET['id']]);
    $id = $_GET['id'];
    $title = $post['title'];
    $content = $post['content'];
    $img = $post['img'];
    $id_topic = $post['id_topic'];
    $publish = empty($post['status']) ? 0 : 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-post'])) {
    // Vars
    $title = strip_tags(htmlspecialchars(trim($_POST['title'])));
    $content = strip_tags(htmlspecialchars(trim($_POST['content'])));
    $topic = trim($_POST['topic']);

    if (!empty($_FILES['img']['name'])) {
        // Vars
        $imgName = time() . '_' . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $fileSize = $_FILES['img']['size'];
        $dimensions = getimagesize($fileTmpName);
        $width = $dimensions[0];
        $height = $dimensions[1];
        $destination = __DIR__ . '/../../assets/img/posts/' . $imgName;

        if (!in_array(strstr($fileType, '/'), ['/jpg', '/jpeg', '/png', '/svg'])) {
            $msg[] = "Error: Only [ 'jpg', 'jpeg', 'png', 'svg' ] - formats allowed here, your file format is: " . strstr($fileType, '/'); return;
        } elseif ($fileSize > 1048576 * 5) {
            $msg[] = 'Error: Your image is big. Maximum file size is 5 MB - your file size is: ' . (float)sprintf('%.2f', ($fileSize / 1048576)) . ' MB';
        } elseif ($width > 1000 || $height > 600) {
            $msg[] = 'Error: Image resolution maximum is 1000x900, your image resolution: ' . $width . 'x' . $height;
        }

        if (!empty($msg)): return;
        endif;

        $result = move_uploaded_file($fileTmpName, $destination);

        if (!$result): $msg[] = "Error: Unknown error while uploading your image to server";
        else: $img = $imgName;
        endif;

    } else {
        $msg[] = "Error: Please choose image for your post";
    }

    if (mb_strlen($title, 'UTF-8') < 3): $msg[] = 'Error: Title can\'t be shorter than 3 characters';
    elseif (mb_strlen($content, 'UTF-8') < 10): $msg[] = 'Error: Content can\'t be shorter than 10 characters';
    elseif (mb_strlen($title, 'UTF-8') > 35): $msg[] = 'Error: Title can\'t be longer than 35 characters';
    elseif ($topic == 0): $msg[] = 'Error: Please choose topic';
    endif;

    if (!empty($msg)): return;
    endif;

    $params = [
        'id_user' => $_SESSION['id'],
        'id_topic' => $topic,
        'title' => $title,
        'content' => $content,
        'img' => $img,
    ];

    update('posts', $params, ['id' => $_POST['id']]);

    header('Location: /admin/posts/index.php');
}

// Publish
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub'])) {
    update('posts', ['status' => 1], ['id' => $_GET['pub']]);

    header('Location: /admin/posts/index.php');
}

// Unpublish
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['unpub'])) {
    update('posts', ['status' => 0], ['id' => $_GET['unpub']]);

    header('Location: /admin/posts/index.php');
}

// Delete post
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del'])) {
    // Delete post image from storage
    $img = selectFromTable('posts', ['img'], 1, ['id' => $_GET['del']])[0]['img'];
    unlink(__DIR__ . '/../../assets/img/posts/' . $img);

    // Delete post
    delete('posts', ['id' => $_GET['del']]);

    header('Location: /admin/posts/index.php');
}
