<?php
require_once __DIR__ . '/../../app/controllers/comments.php';
?>

<?php if (!empty($_SESSION['id'])): ?>
<div class="col-md-12 col-12 comments">
    <hr style="margin-top: 50px">
    <h3>Leave comment ↩</h3>
    <form action="<?= '/Article?id=' . $article_id ?>" method="post">
        <input type="hidden" name="page" value="<?= $article_id ?>">
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Leave your comment</label>
            <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="4" placeholder="Comment..." required></textarea>
        </div>
        <div class="col-12">
            <button type="submit" name="uploadComment" class="btn btn-primary">Upload comment</button>
        </div>
    </form>
    <hr style="margin-bottom: 30px; margin-top: 30px;">
<?php else: ?>
<div class="col-md-12 col-12 comments">
    <hr style="margin-top: 50px; margin-bottom: 30px">
    <div class="card text-center text-bg-secondary py-5 col-md-12 col-12 comments">
      <div class="card-body">
        <h5 class="card-title mb-xxl-4">Login or register to leave a comment</h5>
        <a href="/auth/Login" class="btn btn-primary py-2 px-3">Log in</a>
        <a href="/auth/Registration" class="btn btn-primary py-2 px-3">Register</a>
      </div>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">
<?php endif; ?>

<!--  Show comments  -->
    <?php if (count($comments) > 0): ?>
        <div class="row all-comments">
            <h3 class="col-12">Comments - <?= $comments_count ?></h3>
            <?php foreach ($users as $user): ?>
                <div class="col-12 one-comment">
                    <span><i class="fa-regular fa-user"></i> <?= $user['login'] ?></span>
                    <span><i class="fa-regular fa-calendar"></i> <?= strstr($user['created'], ' ', true) ?> at <?= substr(strstr($user['created'], ' '), 0, -3) ?></span>
                    <div class="col-12 text">
                        <?= $user['comment'] ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>