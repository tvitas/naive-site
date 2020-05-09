<div id="content" class="content uk-margin-top">
<div class="uk-container uk-container-center">
<?php $htmlLen = $html->count(); ?>
<?php if ($htmlLen): ?>
<?php $assoc = $html->last(); ?>
<div class="uk-panel uk-panel-box uk-margin-bottom">
<h1 class="uk-h2 uk-text-danger"><?= $meta->getTitle() ?></h1>
<div class="uk-alert uk-alert-warning" data-uk-alert>
<button type="button" class="uk-alert-close uk-close"></button>
<blockquote>
<?= $meta->getDescription() ?>
</blockquote>
</div>
<hr>
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-3 uk-grid-match" data-uk-grid-margin>
<?php $i = 0; ?>
<?php foreach ($html->all() as $html): ?>
<?php $i++; ?>
<?php if ($i === $htmlLen): ?>
<?php break; ?>
<?php endif; ?>
<div>
<div class="uk-panel uk-panel-box uk-panel-box-default">
<?= $html->getFileContent(); ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<?= $assoc->getFileContent(); ?>
<?php endif; ?>
</div>
</div>

