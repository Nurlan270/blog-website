<?php
    require_once __DIR__ . '/../../app/database/functions.php';
    require_once __DIR__ . '/../../app/controllers/posts.php';
    if (!$_SESSION['admin']):
        header('Location: /errors/403.php');
    else:
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
        $isPosts = true;
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
            <div class="button row">
                <a href="index.php" class="col-3 btn btn-warning">Manage posts</a>
            </div>
            <div class="row title-table">
                <h2>Edit post</h2>
            </div>
            <div class="row add-post">
                <div class="mb-12 col-12 col-md-12 mt-4 err">
                    <?php require_once __DIR__ . '/../../app/helpers/errorInfo.php' ?>
                </div>
                <form action="edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="col">
                        <input name="title" type="text" value="<?= $title ?>" class="form-control" placeholder="Title" aria-label="Title name" required>
                    </div>
                    <div class="col">
                        <textarea name="content" class="form-control" rows="6" placeholder="Content" required><?= $content ?></textarea>
                    </div>
                    <div class="input-group col">
                        <input name="img" type="file" class="form-control" id="inputGroupFile02">
                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                    </div>
                    <select name="topic" class="form-select" aria-label="Default select example">
                        <?php foreach (selectFromTable('topics', ['id', 'name']) as $topic): ?>
                        <?php if ($id_topic === $topic['id']): ?>
                        <option value="<?= $topic['id'] ?>" selected><?= $topic['name'] ?></option>
                        <?php else: ?>
                        <option value="<?= $topic['id'] ?>"><?= $topic['name'] ?></option>
                        <?php endif; endforeach; ?>
                    </select>
                    <div class="col col-6">
                        <button name="edit-post" class="btn btn-primary" type="submit">Edit post ↥</button>
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