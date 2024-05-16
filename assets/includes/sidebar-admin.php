<div class="sidebar col-3">
    <ul>
        <?php if (isset($isPosts)): ?>
        <li><a href="#">Posts ◄◯</a></li>
        <?php else: ?>
        <li><a href="/admin/posts/index.php">Posts</a></li>
        <?php endif; ?>

        <?php if (isset($isUsers)): ?>
        <li><a href="#">Users ◄◯</a></li>
        <?php else: ?>
        <li><a href="/admin/users/index.php">Users</a></li>
        <?php endif; ?>

        <?php if (isset($isCategories)): ?>
        <li><a href="#">Categories ◄◯</a></li>
        <?php else: ?>
        <li><a href="/admin/topics/index.php">Categories</a></li>
        <?php endif; ?>

        <?php if (isset($isComments)): ?>
        <li><a href="#">Comments ◄◯</a></li>
        <?php else: ?>
        <li><a href="/admin/comments/index.php">Comments</a></li>
        <?php endif; ?>
    </ul>
</div>