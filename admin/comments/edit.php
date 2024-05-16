<?php
    require_once __DIR__ . '/../../app/database/functions.php';
    require_once __DIR__ . '/../../app/controllers/comments-admin.php';
    if (!$_SESSION['admin']):
        header('Location: /errors/403.php');
    else:
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
        $isComments = true;
        require_once __DIR__ . '/../../assets/includes/meta.php';
    ?>
    <title>Admin - Posts</title>
  </head>
  <body>
<!--  Header  -->
    <?php require_once __DIR__ . '/../../assets/includes/header-admin.php'; ?>

<div class="container">
    <div class="row">
        <?php require_once __DIR__ . '/../../assets/includes/sidebar-admin.php' ?>

        <div class="posts col-9">
            <a href="/admin/comments/index.php"><button class="btn btn-primary">Go back</button></a>
            <div class="row title-table">
                <h2>Edit comment</h2>
            </div>
            <div class="row add-post">
                <div class="mb-12 col-12 col-md-12 mt-4 err">
                    <?php require_once __DIR__ . '/../../app/helpers/errorInfo.php' ?>
                </div>
                <form action="edit.php" method="post">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    <div class="col">
                        <textarea name="comment" class="form-control" rows="6" placeholder="Content" required><?= $commentText ?></textarea>
                    </div>
                    <div class="col col-6">
                        <button name="edit-comment" class="btn btn-primary" type="submit">Edit comment ↥</button>
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