<footer id="footer-block" class="footer-block">
<div class="uk-container uk-container-center uk-contrast">
<?php if (null !== $footer): ?>
<?php foreach ($footer->all() as $footer): ?>
<?= $footer->getFileContent(); ?>
<?php endforeach; ?>
<?php endif;?>
</div>
</footer>

