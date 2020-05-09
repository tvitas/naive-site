<?php $liClass = '';?>
<?php $hasChild = (null !== $item->getChildren());?>
<?php if ($hasChild): $liClass .= 'uk-parent'; endif; ?>
<?php if ($item->getLocation() === trim($pageUri, '/')): $liClass .= ' uk-active'; endif; ?>
<?php $liClass = trim($liClass); ?>
<?php $icon = $item->getIcon()?>

<li<?php if ($liClass): ?> class="<?= $liClass;?>" <?php endif;?><?php if ($hasChild): ?> data-uk-dropdown="{justify: '#navigation-nav', delay: 700}"<?php endif;?>>
<a href="<?= BASEURL . '/' . $item->getLocation(); ?>" title="<?= $item->getDescription(); ?>">
<?php if ($icon): ?><i class="uk-icon-<?= $icon; ?>"></i>&nbsp;<?php endif;?><?= $item->getTitle(); ?>
</a>

<?php if ($hasChild): ?>

<div class="uk-dropdown uk-dropdown-bottom uk-dropdown-navbar">
<ul class="uk-nav uk-nav-dropdown uk-grid uk-grid-dropdown uk-grid-width-1-5 uk-text-center">
<?php foreach ($item->getChildren()->all() as $item): ?>
<?php include __DIR__ . '/nav-items.html.php'; ?>
<?php endforeach; ?>
</ul>
</div>
</li>

<?php else: ?>
</li>
<?php endif; ?>
