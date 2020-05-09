<?php $liClass = '';?>
<?php $hasChild = (null !== $item->getChildren()); ?>
<?php if ($hasChild): $liClass .= 'uk-parent'; endif; ?>
<?php if ($item->getLocation() === trim($pageUri, '/')): $liClass .= ' uk-active'; endif; ?>
<?php $liClass = trim($liClass); ?>

<li<?php if ($liClass): ?> class="<?= $liClass;?>" <?php endif;?><?php if ($hasChild): ?> data-uk-dropdown<?php endif;?>>
<a href="<?= BASEURL . '/' . $item->getLocation(); ?>" title="<?= $item->getDescription(); ?>"><?= $item->getTitle(); ?></a>

<?php if ($hasChild): ?>

<div class="uk-dropdown uk-dropdown-bottom uk-dropdown-navbar">
<ul class="uk-nav uk-nav-dropdown">
<?php foreach ($item->getChildren()->all() as $item): ?>
<?php include __DIR__ . '/secondary-items.html.php'; ?>
<?php endforeach; ?>
</ul>
</div>
</li>

<?php else: ?>
</li>
<?php endif; ?>
