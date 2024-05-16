<?php if (!empty($msg)): ?>
    <?php foreach ($msg as $singleMsg): ?>
        <li class="alert alert-warning"><?= $singleMsg; ?></li>
    <?php endforeach; ?>
<?php endif; ?>

