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
                <a href="/admin/posts/create.php" class="col-3 btn btn-success">Add post</a>
            </div>
            <div class="row title-table">
                <h2 class="mb-3">Posts management</h2>
                <div class="col-1">ID</div>
                <div class="col-3">TITLE</div>
                <div class="col-2">AUTHOR</div>
                <div class="col-6">MANAGE</div>
            </div>
            <?php
                $categories = selectFromTable('topics');
                if (!$categories):
            ?>
                <p class="alert alert-warning text-center mt-xxl-5 fw-bold fs-5">There are no posts yet</p>
            <?php
                else:
                foreach ($posts as $key => $post):
            ?>
            <div class="row post">
                <div class="id col-1"><?= ++$key ?></div>
                <div class="title col-3"><?= strlen($post['title']) > 28 ? substr($post['title'],0,28)."..." : $post['title'];?></div>
                <div class="author col-2"><?= $post['login'] ?></div>
                <div class="edit col-1"><a href="/admin/posts/edit.php?id=<?= $post['id'] ?>">EDIT</a></div>
                <div class="delete col-2"><a href="/app/controllers/posts.php?del=<?= $post['id'] ?>">DELETE</a></div>
                <?php if ($post['status']): ?>
                <div class="status col text-primary fw-bold"><a href="/app/controllers/posts.php?unpub=<?= $post['id'] ?>">UNPUBLISH ⨉</a></div>
                <?php else: ?>
                <div class="status col text-success fw-bold"><a href="/app/controllers/posts.php?pub=<?= $post['id'] ?>">PUBLISH +</a></div>
                <?php endif; ?>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
<!--  Footer  -->
  <?php require_once __DIR__ . '/../../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php endif; ?>