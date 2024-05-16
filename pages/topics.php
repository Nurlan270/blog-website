<!doctype html>
<html lang="en">
  <head>
    <?php
        require_once __DIR__ . '/../assets/includes/meta.php';
        require_once __DIR__ . '/../app/database/functions.php';
        require_once __DIR__ . '/../app/controllers/search.php';
        if (empty($_GET['topic_id']) || empty(selectFromTable('topics', params: ['id' => $_GET['topic_id']]))) {
            header('Location: /errors/404.php');
        }

        $page = $_GET['page'] ?? 1;
        $limit = 3;
        $offset = $limit * ($page - 1);
        $total_pages = ceil(countTopicRow('posts', $_GET['topic_id']) / $limit);

        require_once __DIR__ . '/../app/controllers/topics.php';

    ?>
    <title>Dynamic website</title>
  </head>
  <body>
<!--  Header  -->
    <?php require_once __DIR__ .'/../assets/includes/header.php'; ?>

<!--  Main  -->

  <div class="container">
      <div class="content row">
          <div class="main-content col-md-9 col-12 mb-5">
              <?php if (empty($posts) && isset($_GET['search-topic'])): ?>
              <p class="alert alert-warning fw-bold fs-4 text-center">Nothing found by search: "
                  <?= strlen(htmlspecialchars(strip_tags($_GET['search-topic']))) > 120
                      ? strip_tags(substr( $_GET['search-topic'], 0, 120)) . "..."
                      : htmlspecialchars(strip_tags($_GET['search-topic']))
                  ?>"
              </p>
              <?php elseif (isset($_GET['search-topic'])): ?>
              <h3>Search results</h3>
              <?php elseif (empty($posts) && $page > $total_pages): ?>
              <p class="alert alert-warning fw-bold fs-4 text-center" style="margin-top: 93px">There are no posts in this page.</p>
              <?php
                else:
                $topicName = selectAllFromPostsWithTopics('posts', 'topics', $_GET['topic_id'])[0]['name'];
              ?>
              <h3>Topic publications - <?= $topicName ?></h3>
              <?php
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

<!--          Pagination    -->
              <?php require_once __DIR__ . '/../assets/includes/pagination.php' ?>
          </div>

<!--   Sidebar     -->
          <?php require_once __DIR__ . '/../assets/includes/sidebar.php'; ?>
      </div>
  </div>

  <?php require_once __DIR__ . '/../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>