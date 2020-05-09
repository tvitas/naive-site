<ul class="uk-navbar-nav">
<li<?php if ('front' === $pageUri):?> class="uk-active"<?php endif;?>><a href="<?= BASEURL ?>" class="uk-text-warning"><i class="uk-icon uk-icon-home"></i></a></li>
</ul>
<?php if (null !== $nav): ?>
<?php $items = $nav->getItems();?>
<?php if ($items->count()): ?>
<ul id="nav-ul" class="uk-navbar-nav uk-navbar-attached">
<?php foreach ($items->all() as $item): ?>
<?php include __DIR__ . '/partials/nav-items.html.php' ?>
<?php endforeach; ?>
</ul>
<?php endif;?>
<?php endif;?>
