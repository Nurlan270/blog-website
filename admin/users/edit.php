<?php
    require_once __DIR__ . '/../../app/database/functions.php';
    require_once __DIR__ . '/../../app/controllers/users.php';
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
                <a href="index.php" class="col-3 btn btn-warning">Manage users</a>
            </div>
            <div class="row title-table">
                <h2>Edit user</h2>
            </div>
            <div class="row add-post">
                <div class="mb-12 col-12 col-md-12 mt-4 err">
                    <?php require_once __DIR__ . '/../../app/helpers/errorInfo.php' ?>
                </div>
                <form action="edit.php" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="login" id="login" value="<?= $user['login'] ?>"
                                   placeholder="Your login..." required>
                            <label for="login" class="form-label">Login</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" readonly name="email" id="email" value="<?= $user['email'] ?>"
                                   placeholder="user@mail.com">
                            <label for="email" class="form-label">Email</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="pass" id="pass"
                                   placeholder="Your password" required>
                            <label for="pass" class="form-label">Password</label>
                        </div>
                    </div>
                    <select name="role" class="form-select" aria-label="Default select example">
                        <?php if (!empty($user['admin'])): ?>
                        <option value="1" selected>Admin</option>
                        <option value="0">User</option>
                        <?php else: ?>
                        <option value="0" selected>User</option>
                        <option value="1">Admin</option>
                        <?php endif; ?>
                    </select>
                    <div class="col-12">
                        <button class="btn btn-primary" name="edit-btn" type="submit">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  Footer  -->
  <?php require_once __DIR__ . '/../../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php endif; ?>
