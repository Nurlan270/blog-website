<?php
    require_once __DIR__ . '/../../app/database/functions.php';
    if (!$_SESSION['admin']):
        header('Location: /errors/403.php');
    else:
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
        $isUsers = true;
        require_once __DIR__ . '/../../assets/includes/meta.php';
    ?>
    <title>Admin - Users</title>
  </head>
  <body>
<!--  Header  -->
    <?php require_once __DIR__ . '/../../assets/includes/header-admin.php'; ?>

<div class="container">
    <div class="row">
        <?php require_once __DIR__ . '/../../assets/includes/sidebar-admin.php' ?>

        <div class="posts col-9">
            <div class="button row">
                <a href="create.php" class="col-3 btn btn-success">Create user</a>
            </div>
            <div class="row title-table">
                <h2 class="mb-3">Users management</h2>
                <div class="col-1">ID</div>
                <div class="col-5">LOGIN</div>
                <div class="col-2">ADMIN</div>
                <div class="col-4">MANAGE</div>
            </div>
            <?php foreach (selectFromTable('users', ['id', 'login', 'admin']) as $key => $user):  ?>
            <div class="row post">
                <div class="id col-1"><?= ++$key ?></div>
                <div class="login col-5"><?= $user['login'] ?></div>
                <?php if (!empty($user['admin'])): ?>
                <div class="admin col-2">Yes</div>
                <?php else: ?>
                <div class="admin col-2">No</div>
                <?php endif; ?>
                <div class="edit col-2"><a href="/admin/users/edit.php?id=<?= $user['id'] ?>">EDIT</a></div>
                <div class="delete col-2"><a href="/app/controllers/users.php?del_id=<?= $user['id'] ?>"">DELETE</a></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!--  Footer  -->
  <?php require_once __DIR__ . '/../../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php endif; ?>