<?php $liClass = '';?>
<?php $hasChild = (null !== $item->getChildren()); ?>
<?php if ($hasChild): $liClass .= 'uk-parent'; endif; ?>
<?php if ($item->getLocation() === $pageUri): $liClass .= ' uk-active'; endif; ?>
<?php $liClass = trim($liClass); ?>
<?php $icon = $item->getIcon()?>

<li<?php if ($liClass): ?> class="<?= $liClass;?>" <?php endif;?>>
<a href="<?= BASEURL . '/' . $item->getLocation(); ?>" title="<?= $item->getDescription(); ?>">
<?php if ($icon): ?><i class="uk-icon-<?= $icon; ?>"></i>&nbsp;<?php endif;?><?= $item->getTitle(); ?>
</a>
<?php if ($hasChild): ?>
<ul class="uk-nav uk-nav-sub">
<?php foreach ($item->getChildren()->all() as $item): ?>
<?php include __DIR__ . '/offcanvas-items.html.php'; ?>
<?php endforeach; ?>
</ul>
</li>
<?php else: ?>
</li>
<?php endif; ?>
