<!doctype html>
<html lang="en">
  <head>
    <?php
        require_once '../assets/includes/meta.php';
        require_once __DIR__ . '/../app/database/functions.php';
        require_once __DIR__ . '/../app/controllers/posts.php';
        if (empty($_GET['id']) || empty(selectFromTable('posts', params: ['id' => $_GET['id']]))){
            header('Location: /errors/404.php');
        }
        $img = selectFromTable('posts', ['img'], params: ['id' => $_GET['id']])[0]['img'];
    ?>
    <title>Article page</title>
  </head>
  <body>
<!--  Header  -->
    <?php require_once '../assets/includes/header.php'; ?>

<!--  Main  -->

  <div class="container">
      <div class="content row mb-5">
          <div class="main-content col-md-9 col-12">
              <h3><?= selectFromTable('posts', ['title'], params: ['id' => $_GET['id']])[0]['title'] ?></h3>
              <div class="single_post row">
                  <img src="<?= '/assets/img/posts/' . $img ?>" alt="" class="img-thumbnail" style="width: min-content; height: min-content;">
                  <div class="info">
                    <i class="far fa-user"> &nbsp; <?= selectAllFromPostsWithUsers('posts', 'users')[0]['login'] ?></i>
                    <i class="far fa-calendar"> &nbsp; <?= strstr(selectFromTable('posts', ['created'], params: ['id' => $_GET['id']])[0]['created'], ' ', true) ?> at <?= substr(strstr(selectFromTable('posts', ['created'], params: ['id' => $_GET['id']])[0]['created'], ' '), 0, -3) ?></i>
                    <i class="bi bi-eye" style="margin-right: 3px"></i> <?= $views ?>
                  </div>
                <div class="single_post_text col-12">
                    <article id="post_content" style="white-space: pre-wrap; overflow-wrap: break-word">
                        <?= selectFromTable('posts', ['content'], params: ['id' => $_GET['id']])[0]['content'] ?>
                    </article>
                </div>

<!--            Comments         -->
                <?php require_once __DIR__ . '/../assets/includes/comments.php' ?>
              </div>

          </div>

<!--      Sidebar     -->
          <?php require_once '../assets/includes/sidebar.php'; ?>
      </div>
  </div>

<!--   Footer     -->
  <?php require_once '../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    // Trim content text
    var contentElement = document.getElementById("post_content");
    var trimmedContent = contentElement.textContent.trim();
    contentElement.textContent = trimmedContent;
</script>
  </body>
</html>