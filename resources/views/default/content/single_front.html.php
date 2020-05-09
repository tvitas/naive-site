<div id="content-front" class="content-front">
<?php foreach ($html->all() as $html): ?>
<?= $html->getFileContent(); ?>
<?php endforeach; ?>
</div>
