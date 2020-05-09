<div id="offcanvas-bar" class="uk-offcanvas">
<div class="uk-offcanvas-bar">
<ul class="uk-nav uk-nav-offcanvas">
<li<?php if ('front' === $pageUri):?> class="uk-active"<?php endif;?>><a href="<?= BASEURL ?>"><i class="uk-icon uk-icon-home"></i></a></li>
</ul>
<?php foreach($offcanvas->all() as $oItem): ?>
<?php $items = $oItem->getItems(); ?>
<?php if (0 !== $items->count()): ?>
<ul class="uk-nav uk-nav-offcanvas">
<?php foreach ($items->all() as $item): ?>
<?php include __DIR__ . '/partials/offcanvas-items.html.php' ?>
<?php endforeach; ?>
</ul>
<?php endif;?>
<?php endforeach ;?>
<?php if (true === $session->get('auth')): ?>
<ul class="uk-nav uk-nav-offcanvas">
<li>
<a href="#" title="Logout" onClick="javascript: event.preventDefault(); document.getElementById('logout-form').submit();"><i class="uk-icon-user-times" style="cursor: pointer;"></i>&nbsp;Logout</a>
</li>
<ul>
<?php endif; ?>
</div>
</div>

