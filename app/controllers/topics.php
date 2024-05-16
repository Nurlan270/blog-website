<?php

require_once __DIR__ . '/../database/functions.php';

$msg = [
    'st' => '',
    'msg' => ''
];

// Create category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-category'])) {
    $category_name = trim($_POST['name']);
    $category_description = trim($_POST['description']);

    if (strlen($category_name) < 3): $msg = [
        'st' => 'S',
        'msg' => 'Name can\'t be shorter than 3 characters!'
    ];
    endif;

    try {
        insert('topics', ['name' => $category_name, 'description' => $category_description]);
        $msg = [
            'st' => 'S',
            'msg' => 'Category created successfully'
        ];
    } catch (PDOException $e) {
        $msg = [
            'st' => 'E',
            'msg' => "Something went wrong. <br /> Error msg: " . $e->getMessage()
        ];
    }
} else {
    $category_name = '';
    $category_description = '';
}

// Update category
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $category_name = selectFromTable('topics', ['name'], 1, ['id' => $id])[0]['name'];
    $category_description = selectFromTable('topics', ['description'], 1, ['id' => $id])[0]['description'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-category'])) {
    $category_name = trim($_POST['name']);
    $category_description = trim($_POST['description']);

    if (strlen($category_name) < 3) {
        $msg = [
            'st' => 'E',
            'msg' => 'Name can\'t be shorter than 3 characters!'
        ];
    } else
    {
    try {
        update('topics', [
            'name' => $category_name,
            'description' => $category_description
        ], ['id' => $_POST['id']]);

        header('Location: /admin/topics/index.php');
    } catch (PDOException $e) {
        $msg = [
            'st' => 'E',
            'msg' => "Something went wrong. <br /> Error msg: " . $e->getMessage()
        ];
    }
    }
}

// Delete category
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    delete('topics', ['id' => $_GET['del_id']]);

    header('Location: /admin/topics/index.php');
}

// Show categories in main page
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['topic_id'])) {
    $posts = selectFromTableByLimit('posts', $limit, $offset, params: ['id_topic' => $_GET['topic_id'], 'status' => 1]);
}