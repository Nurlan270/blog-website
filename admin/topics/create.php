<?php
    require_once __DIR__ . '/../../app/database/functions.php';
    require_once __DIR__ . '/../../app/controllers/topics.php';
    if (!$_SESSION['admin']):
        header('Location: /errors/403.php');
    else:
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
        $isCategories = true;
        require_once __DIR__ . '/../../assets/includes/meta.php';
    ?>
    <title>Admin - Categories</title>
  </head>
  <body>
<!--  Header  -->
    <?php require_once __DIR__ . '/../../assets/includes/header-admin.php'; ?>

<div class="container">
    <div class="row">
        <?php require_once __DIR__ . '/../../assets/includes/sidebar-admin.php' ?>

        <div class="posts col-9">
            <div class="button row">
                <a href="index.php" class="col-3 btn btn-warning">Manage categories</a>
            </div>
            <div class="row title-table">
                <h2>Create category</h2>
            </div>
            <div class="row add-post">
                <form action="create.php" method="post">
                    <div class="col">
                        <input name="name" type="text" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="col">
                        <textarea name="description" class="form-control" rows="6" placeholder="Category description (optional)"></textarea>
                    </div>
                    <?php if ($msg['st'] === 'S'): ?>
                    <p class="alert alert-success"><?= $msg['msg'] ?></p>
                    <?php elseif ($msg['st'] === 'E'): ?>
                    <p class="alert alert-danger"><?= $msg['msg'] ?></p>
                    <?php endif; ?>
                    <div class="col-12">
                        <button name="create-category" class="btn btn-primary" type="submit">Create category ↥</button>
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
