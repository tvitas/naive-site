<header id="header-block" class="uk-cover-background header-block uk-hidden-small">
<?php if (null !== $header): ?>
<div class="uk-width-2-10 uk-float-left">
<?= $header->last()->getFileContent(); ?>
</div>
<?php endif;?>
<div class="uk-text-center uk-width-6-10 uk-float-left">
<h2 class="uk-contrast" style="margin-top: 100px;"><?= $site->getName(); ?></h2>
<h3 class="uk-contrast uk-hidden-large uk-hidden-medium uk-hidden-small"><?= $site->getSlogan(); ?></h3>
</div>
<?php if (null !== $header): ?>
<div class="uk-width-2-10 uk-float-right">
<?= $header->first()->getFileContent(); ?>
</div>
<?php endif;?>
<div class="uk-clearfix"></div>
</header>
