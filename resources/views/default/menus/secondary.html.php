<?php if (null !== $secondary): ?>
<div id="navigation-top" class="uk-hidden-small">
<nav class="uk-navbar uk-navbar-attached uk-secondary">
<div class="uk-navbar-flip">
<?php $items = $secondary->getItems();?>
<?php if ($items->count()): ?>
<ul class="uk-navbar-nav uk-navbar-attached">
<?php foreach ($items->all() as $item): ?>
<?php include __DIR__ . '/partials/secondary-items.html.php' ?>
<?php endforeach; ?>
</ul>
<?php endif;?>
<?php if (true === $session->get('auth')): ?>
<ul class="uk-navbar-nav uk-navbar-attached">
<li><a href="#" title="<?= $session->get('user')['description']?>"><?= $session->get('user')['name'] ?? '' ?></a></li>
<li>
<form action="<?= BASEURL . '/logout'?>" method="POST" id="logout-form" style="display: none;"><input type="hidden" name="__token__" value="<?= $token ?>"></form>
<a href="#" title="Logout" class="uk-text-danger" onClick="javascript: event.preventDefault(); document.getElementById('logout-form').submit();" style="cursor: pointer;"><i class="uk-icon-user-times uk-text-danger" style="cursor: pointer;"></i>&nbsp;Logout</a>
</li>
<ul>
<?php endif; ?>
</div>
</nav>
</div>
<?php endif; ?>
