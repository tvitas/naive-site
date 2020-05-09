<div id="content" class="content uk-margin-top">
<div class="uk-container uk-container-center">
<div class="uk-panel uk-panel-box uk-margin-bottom">
<?php if (null !== $meta): ?>
<h1 class="uk-h2 uk-text-danger"><?= $meta->getTitle() ?></h1>
<div class="uk-alert uk-alert-warning" data-uk-alert>
<button type="button" class="uk-alert-close uk-close"></button>
<blockquote>
<?= $meta->getDescription() ?>
</blockquote>
</div>
<?php endif; ?>
<?php if (null !== $html): ?>
<?php foreach ($html->all() as $html): ?>
<article>
<?= $html->getFileContent(); ?>
</article>
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
