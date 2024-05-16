<?php

session_start();

require_once __DIR__ . '/connection.php';

//  Pretty array
function prettyArray(array $array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

//  PDO Error checking
function executeSafely($query, $flag = 1, $values = '', $default = 0)
{
    try {
        if ($flag == 1): $query->execute();
        elseif ($flag == 2): $query->execute($values);
        endif;
    } catch (PDOException $e) {
        if (empty($default)) {
            if ($e->errorInfo[0] === '42S22'): exit('Provided not correct column name. Please re-check' . '<br />' . 'Line: ' . $e->getLine());
            elseif ($e->errorInfo[0] === '42S02'): exit('Provided table doesn\'t exists.' . '<br />' . 'Line: ' . $e->getLine());
            elseif ($e->errorInfo[0] === '42000'): exit('Syntax error.' . '<br />' . 'Line: ' . $e->getLine());
            elseif ($e->errorInfo[0] === '23000'): exit('Duplicate in data, you used existing data.' . '<br />' . 'Line: ' . $e->getLine());
            endif;
        } else {
            print_r($e->errorInfo);
        }
    }
}

//  Select from table
function selectFromTable(string $table, array $columns = ['*'], int $limit = 0, array $params = [], $order_by_desc = false): array|string
{
    // Vars
    global $pdo;
    $columns = implode(',', $columns);
    $prms = '';

//  SELECT * FROM `posts` ORDER BY `posts`.`id` ASC
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            if ($key !== array_key_last($params)): $prms .= " $key = '$value' AND";
            else: $prms .= " $key = '$value'";
            endif;
        }
        if (!empty($limit)) {
            $query = $pdo->prepare("SELECT $columns FROM $table WHERE $prms LIMIT $limit");
        } else {
            $query = $pdo->prepare("SELECT $columns FROM $table WHERE $prms");
        }
    } elseif (!empty($limit)) {
        $query = $pdo->prepare("SELECT $columns FROM $table LIMIT $limit");
    } elseif ($order_by_desc) {
        $query = $pdo->prepare("SELECT $columns FROM $table ORDER BY id DESC");
    } else {
        $query = $pdo->prepare("SELECT $columns FROM $table");
    }

    executeSafely($query);

    return $query->fetchAll();
}

function selectFromTableByOrder(string $table, array $columns = ['*'], array $params = []): array|string
{
    // Vars
    global $pdo;
    $columns = implode(',', $columns);
    $prms = '';

    if (!empty($params)) {
        foreach ($params as $key => $value) {
            if ($key !== array_key_last($params)): $prms .= " $key = '$value' AND";
            else: $prms .= " $key = '$value'";
            endif;
        }
    }

    $query = $pdo->prepare("SELECT $columns FROM $table WHERE $prms ORDER BY id DESC");

    executeSafely($query);

    return $query->fetchAll();
}

function selectFromTableByLimit(string $table, $limit, $offset, array $columns = ['*'], array $params = []): array|string
{
    // Vars
    global $pdo;
    $columns = implode(',', $columns);
    $prms = '';

    if (!empty($params)) {
        foreach ($params as $key => $value) {
            if ($key !== array_key_last($params)): $prms .= " $key = '$value' AND";
            else: $prms .= " $key = '$value'";
            endif;
        }
    }

    $query = $pdo->prepare("SELECT $columns FROM $table WHERE $prms ORDER BY id DESC LIMIT $limit OFFSET $offset");

    executeSafely($query);

    return $query->fetchAll();
}

//  Insert into table
function insert(string $table, array $params)
{
    //  Strict check
//    if (count($params) != 4) {
//        exit("Provide correct quantity of parameters. <br /> You provided: " . count($params) . " elements, 4 required.");
//    }

    global $pdo;
    $keys = '';
    $placeholders = '';

    $keysArr = array_keys($params);
    $values = array_values($params);

    foreach ($keysArr as $key => $value) {
        if ($key !== array_key_last($keysArr)):
            $keys .= "$value, ";
            $placeholders .= "?, ";
        else:
            $keys .= "$value";
            $placeholders .= "?";
        endif;
    }

    $query = $pdo->prepare("INSERT INTO $table ($keys) VALUES ($placeholders)");

    executeSafely($query, 2, $values);
}

//  Update table
function update(string $table, array $params, $where = [])
{
    global $pdo;
    $keys = '';
    $prms = '';
    $arg = '';


    foreach ($params as $key => $value) {
        if ($key !== array_key_last($params)):
            $prms .= "$key = '$value', ";
        else:
            $prms .= "$key = '$value'";
        endif;
    }

    foreach ($where as $key => $value) {
        $arg .= "$key = '$value'";
    }

    $query = $pdo->prepare("UPDATE $table SET $prms WHERE $arg");

    executeSafely($query, default: 1);
}

//  Delete from table
function delete(string $table, $where)
{
    global $pdo;
    $arg = '';

    foreach ($where as $key => $value) {
        $arg .= "$key = '$value'";
    }

    $query = $pdo->prepare("DELETE FROM $table WHERE $arg");

    executeSafely($query);
}

// Choose (join)
function selectAllFromPostsWithUsers(string $table1, string $table2)
{
    global $pdo;

    $sql = "
    SELECT 
    t1.id,
    t1.id_topic,
    t1.title,
    t1.img,
    t1.content,
    t1.status,
    t1.created,
    t2.login
    FROM $table1 AS t1, $table2 AS t2 WHERE t1.id_user = t2.id";

    $query = $pdo->prepare($sql);
    executeSafely($query);
    return $query->fetchAll();
}

function selectAllFromPostsWithTopics(string $table1, string $table2, $id)
{
    global $pdo;

    $sql = "
    SELECT 
    t1.*,
    t2.name
    FROM $table1 AS t1, $table2 AS t2 WHERE t1.id_topic = t2.id AND id_topic = '$id'";

    $query = $pdo->prepare($sql);
    executeSafely($query);
    return $query->fetchAll();
}

function selectByLike(string $table, string $param, string $like, string $flag, array $columns = ['*'])
{
    global $pdo;
    $columns = implode(',', $columns);

    if ($flag === 'START'): $query = $pdo->prepare("SELECT $columns FROM $table WHERE $param LIKE '%$like'");
    elseif ($flag === 'END'): $query = $pdo->prepare("SELECT $columns FROM $table WHERE $param LIKE '$like%'");
    elseif ($flag === 'BOTH'): $query = $pdo->prepare("SELECT $columns FROM $table WHERE $param LIKE '%$like%'");
    endif;

    executeSafely($query);

    return $query->fetchAll();
}

function selectByLikeWhere(string $table, string $like, array $where, array $columns = ['*'])
{
    global $pdo;
    $columns = implode(',', $columns);
    $whr = '';

    foreach ($where as $key => $value) {
        $whr .= "$key = '$value'";
    }

    $query = $pdo->prepare("SELECT $columns FROM $table WHERE title LIKE '%$like%' AND $whr");

    executeSafely($query);

    return $query->fetchAll();
}

function countRow(string $table, $article_id = '', $flag = 1)
{
    global $pdo;

    if ($flag == 1): $query = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE status = 1");
    elseif ($flag == 2): $query = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE article_id = $article_id");
    endif;

    executeSafely($query, default: 1);

    return $query->fetchColumn();
}

function countTopicRow(string $table, $id_topic)
{
    global $pdo;

    $query = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE status = 1 AND id_topic = $id_topic");

    executeSafely($query);

    return $query->fetchColumn();
}

function selectCommentsJoinUsers(string $table1, string $table2, $article_id, array $columns = ['*'])
{
    global $pdo;
    $columns = implode(',', $columns);

    $query = $pdo->prepare("SELECT $columns FROM $table1 AS t1 JOIN $table2 AS t2
    WHERE t1.article_id = $article_id AND t1.email = t2.email ORDER BY t1.created DESC");

    executeSafely($query);

    return $query->fetchAll();
}