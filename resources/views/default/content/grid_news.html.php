<div id="content" class="content uk-margin-top">
<div class="uk-container uk-container-center">

<div class="uk-panel uk-panel-box uk-margin-bottom">
<h1 class="uk-h2 uk-text-danger"><?= $meta->getTitle() ?></h1>
<div class="uk-alert uk-alert-warning" data-uk-alert>
<button type="button" class="uk-alert-close uk-close"></button>
<blockquote>
<?= $meta->getDescription() ?>
</blockquote>
</div>
<hr>
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-2 uk-grid-match" data-uk-margin>
<?php foreach ($html->all() as $html): ?>
<article>
<div class="uk-panel uk-panel-box uk-panel-box-default">
<?php if ($meta->getTeaser()): ?>
<?= $truncator->truncate($html->getFileContent(), 150); ?>
<?php $href = BASEURL . $pageUri . '/' . $html->getFilename(); ?>
<a class="uk-text-danger" href="<?= $href; ?>"><small>More</small></a>
<?php else: ?>
<?= $html->getFileContent(); ?>
<?php endif; ?>
</div>
</article>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
