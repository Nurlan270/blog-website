<!doctype html>
<html lang="en">
  <head>
    <?php
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', __DIR__ . '/log.txt');

        require_once './assets/includes/meta.php';
        require_once __DIR__ . '/app/database/functions.php';
        $isHome = true;

        // Pagination
        $page = $_GET['page'] ?? 1;
        $limit = 3;
        $offset = $limit * ($page - 1);
        $total_pages = ceil(countRow('posts') / $limit);

        $posts = selectFromTableByLimit('posts', $limit, $offset, params: ['status' => 1]);
        $topTopic = selectFromTable('posts', params: ['id_topic' => 51]);

        require_once __DIR__ . '/app/controllers/search.php';
    ?>
    <title>Dynamic website</title>
  </head>
  <body>
<!--  Header  -->
    <?php require_once './assets/includes/header.php'; ?>

<!--  Carousel  -->
<?php if (empty($_GET['search-term'])): ?>
    <div class="container">
      <div class="row">
        <h3 class="text-center py-4">Top publications</h3>
      </div>
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <?php foreach ($topTopic as $key => $post): ?>
                <?php if ($key === 0): ?>
                <div class="carousel-item active">
                <?php else: ?>
                <div class="carousel-item">
                <?php endif; ?>
                    <img src="/assets/img/posts/<?= $post['img'] ?>" class="d-block w-100" alt="...">
                    <div class="carousel-caption-hack carousel-caption d-none d-md-block">
                      <h5><a href="/Article?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h5>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
    </div>
<?php endif; ?>
<!--  Main  -->

  <div class="container">
      <div class="content row">
          <div class="main-content col-md-9 col-12 mb-5">
              <?php if (isset($_GET['search-term'])): ?>
              <h3>Search results</h3>
              <?php else: ?>
              <h3>Latest publications</h3>
              <?php endif; ?>
              <?php if (!$posts && isset($_GET['search-term'])): ?>
              <p class="alert alert-warning fw-bold fs-4 text-center">Nothing found by search: "
                  <?= strlen(htmlspecialchars(strip_tags($_GET['search-term']))) > 120
                      ? strip_tags(substr( $_GET['search-term'], 0, 120)) . '...'
                      : htmlspecialchars(strip_tags($_GET['search-term']))
                  ?>"
              </p>
              <?php elseif (!$posts): ?>
              <p class="alert alert-warning fw-bold fs-4 text-center">There are no posts in this page.</p>
              <?php
                    else:
                    foreach ($posts as $key => $post):
              ?>
              <div class="post row">
                <div class="img col-12 col-md-4">
                  <img src="<?= '/assets/img/posts/' . $post['img'] ?>" alt="" class="img-thumbnail" style="height: 100%; object-fit: revert">
                </div>
                <div class="post_text col-12 col-md-8">
                  <h4>
                    <a href="/Article?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                  </h4>
                  <i class="far fa-user"> &nbsp; <?= selectAllFromPostsWithUsers('posts', 'users', ['login'])[$key++]['login'] ?></i>
                  <i class="far fa-calendar"> &nbsp; <?= strstr($post['created'], ' ', true) ?></i>
                  <p class="preview-text" style="overflow-wrap: break-word"><?php
                      if (strlen($post['content']) > 220): echo substr($post['content'], 0, 220) . "<a style=\"text-decoration: underline !important; color: #008484;\" href=\"/Article?id=" . $post['id'] . "\">...Read more</a>";
                      else: echo $post['content'];
                      endif;
                  ?>
                  </p>
                </div>
              </div>
              <?php endforeach; endif; ?>

<!--           Pagination         -->
              <?php require_once __DIR__ . '/assets/includes/pagination.php' ?>
          </div>

<!--      Sidebar     -->
          <?php require_once './assets/includes/sidebar.php'; ?>
      </div>
  </div>

  <?php require_once './assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>