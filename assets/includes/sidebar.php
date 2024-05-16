<?php require_once __DIR__ . '/../../app/controllers/search.php' ?>
<div class="sidebar col-md-3 col-12">
    <?php if (!empty($isHome)): ?>
    <div class="section search">
        <h3 title="❕ Searching run by title names">Search</h3>
        <form action="/" method="get">
            <input type="search" name="search-term" value="<?= $search ?>" class="text-input" placeholder="Search...">
        </form>
    </div>
    <?php endif; ?>

<!--   Home page        -->
    <?php if (!empty($isHome)): ?>
    <div class="section topics">
        <h3>Topics</h3>
        <ul>
            <?php
            $topics = selectFromTable('topics', ['id', 'name', 'description']);
            foreach ($topics as $topic):
            ?>
            <li><a href="/Topics?topic_id=<?= $topic['id'] ?>&page=1" title="<?= $topic['description'] ?>"><?= $topic['name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

<!--   None Home page        -->
    <?php else: ?>
    <div class="section topics" style="margin-top: 93px">
        <h3>Topics</h3>
        <ul>
            <?php
            $topics = selectFromTable('topics', ['id', 'name', 'description']);
            foreach ($topics as $topic):
            ?>
            <li><a href="/Topics?topic_id=<?= $topic['id'] ?>&page=1" title="<?= $topic['description'] ?>"><?= $topic['name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>