<?php if ($total_pages > 1 && isset($isHome)): ?>
<!--     Home pagination       -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <?php if ($page > 1): ?>
    <li class="page-item">
       <a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a>
    </li>
    <?php endif; ?>
    <?php for($i = 1; $i != ($total_pages + 1); $i++): ?>
        <?php if ($page == $i): ?>
            <li class="page-item active">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $total_pages): ?>
    <li class="page-item">
      <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
    </li>
    <?php endif; ?>
  </ul>
</nav>

<?php elseif ($total_pages > 1): ?>
<!--     Topic pagination       -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <?php if ($page > 1): ?>
    <li class="page-item">
       <a class="page-link" href="?topic_id=<?= $_GET['topic_id'] ?>&page=<?= $page - 1 ?>">Prev</a>
    </li>
    <?php endif; ?>
    <?php for($i = 1; $i != ($total_pages + 1); $i++): ?>
        <?php if ($page == $i): ?>
            <li class="page-item active">
                <a class="page-link" href="?topic_id=<?= $_GET['topic_id'] ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link" href="?topic_id=<?= $_GET['topic_id'] ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $total_pages): ?>
    <li class="page-item">
      <a class="page-link" href="?topic_id=<?= $_GET['topic_id'] ?>&page=<?= $page + 1 ?>">Next</a>
    </li>
    <?php endif; ?>
  </ul>
</nav>

<?php endif; ?>
