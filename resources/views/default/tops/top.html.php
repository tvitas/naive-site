<?php if (null !== $top): ?>
<?php $itemsCount = count($top->all());?>
<?php $slides = 2; ?>
<?php if ($itemsCount and $itemsCount < 2): ?>
<?php $slides = 1; ?>
<?php endif;?>
<?php if ($itemsCount): ?>
<div id="top" class="top uk-margin-top">
<div class="uk-container uk-container-center">
<h2 class="uk-text-danger uk-text-center">Latest News</h2>
<div data-uk-slideset="{default: <?= $slides ?>, animation: 'fade', duration: 200}">
<div class="uk-slidenav-position uk-margin-bottom">
<ul class="uk-grid uk-slideset">
<?php foreach ($top->all() as $item): ?>
<li>
<div class="uk-panel uk-panel-box">
<?= $truncator->truncate($item->getFileContent(), 300); ?>
<?php $more = $item->getOrigin(); ?>
<?php if ($more): ?>
<a href="<?= BASEURL . '/' . $more;?>/<?=$item->getFileName()?>" class="uk-text-danger"><small>More</small></a>
<?php endif;?>
</div>
</li>
<?php endforeach; ?>
</ul>
<?php if ($itemsCount > 2): ?>
<a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
<a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
<?php endif;?>
</div>
<?php if ($itemsCount > 2): ?>
<ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
<?php endif; ?>
</div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>
