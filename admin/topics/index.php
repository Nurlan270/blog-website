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
                <a href="create.php" class="col-3 btn btn-success">Add category</a>
            </div>
            <div class="row title-table">
                <h2 class="mb-3">Categories management</h2>
                <div class="col-1">ID</div>
                <div class="col-5">NAME</div>
                <div class="col-4">MANAGE</div>
            </div>
            <?php
                $categories = selectFromTable('topics');
                if (!$categories):
            ?>
                <p class="alert alert-warning text-center mt-xxl-5 fw-bold fs-5">There are no categories yet</p>
            <?php else:
                foreach ($categories as $key => $category):
            ?>
                    <div class="row post">
                        <div class="id col-1"><?= ++$key ?></div>
                        <div class="title col-5"><?= $category['name'] ?></div>
                        <div class="edit col-2"><a href="edit.php?id=<?= $category['id'] ?>">EDIT</a></div>
                        <div class="delete col-2"><a href="/app/controllers/topics.php?del_id=<?= $category['id'] ?>">DELETE</a></div>
                    </div>
            <?php
                endforeach;
                endif;
            ?>
        </div>
    </div>
</div>

<!--  Footer  -->
  <?php require_once __DIR__ . '/../../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php endif; ?>