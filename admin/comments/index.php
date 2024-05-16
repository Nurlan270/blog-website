<?php
    require_once __DIR__ . '/../../app/database/functions.php';
    require_once __DIR__ . '/../../app/controllers/posts.php';
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
        require_once __D. '/../../assets/includes/hp';
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
            <div class="row title-table">
                <h2 class="mb-3">Comments management</h2>
                <div class="col-1">ID</div>
                <div class="col-3">CONTENT</div>
                <div class="col-3">AUTHOR</div>
                <div class="col-3">MANAGE</div>
            </div>
            <?php
                if (!$comments):
            ?>
                <p class="alert alert-warning text-center mt-xxl-5 fw-bold fs-5">There are no comments yet</p>
            <?php
                else:
                foreach ($comments as $key => $comment):
            ?>
            <div class="row post">
                <div class="id col-1"><?= ++$key ?></div>
                <div class="title col-3"><?= strlen($comment['comment']) > 28 ? substr($comment['comment'],0,28)."..." : $comment['comment'];?></div>
                <div class="author col-3"><?= strlen($comment['email']) > 20 ? substr($comment['email'],0,28)."..." : $comment['email'];?></div>
                <div class="edit col-2"><a href="/admin/comments/edit.php?id=<?= $comment['id'] ?>">EDIT</a></div>
                <div class="delete col-1"><a href="/app/controllers/comments-admin.php?del=<?= $comment['id'] ?>">DELETE</a></div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
<!--  Footer  -->
    <?php require_once __DIR__ . '/../../app/controllers/email.php' ?>
  <?php require_once __DIR__ . '/../../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php endif; ?>