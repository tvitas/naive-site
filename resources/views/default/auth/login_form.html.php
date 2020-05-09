<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $site->getName() ?> | Login</title>
<link href="<?= BASEURL . '/assets/uikit/css/uikit.almost-flat.min.css' ?>" rel="stylesheet">
<link href="<?= BASEURL . '/assets/css/cccf.css' ?>" rel="stylesheet">
<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>
</head>
<body style="height: 100vh;">
<header id="header-block" class="uk-cover-background header-block uk-hidden-small uk-margin-bottom">
<div class="uk-container uk-container-center">
<div class="uk-text-center">
<h2 class="uk-contrast"><?= $site->getName(); ?></h2>
<h3 class="uk-contrast uk-hidden-large uk-hidden-medium uk-hidden-small"><?= $site->getSlogan(); ?></h3>
</div>
</div>
</header>
<div class="uk-flex uk-flex-middle uk-margin-top">
<div class="uk-width-large-1-3 uk-width-medium-1-2 uk-width-small-1-1 uk-panel uk-panel-box uk-container-center">
<?php if (false === $auth): ?>
<h3 class="uk-text-danger uk-text-center uk-hidden-large uk-hidden-medium"><?= $site->getName() ?></h3>
<p class="uk-text-warning uk-text-center">Please login to the members area</p>
<?php else: ?>
<p class="uk-text-warning uk-text-center">Your are already logged in. Logout?</p>
<?php endif;?>
<hr>
<?php foreach ($session->getFlashBag()->all() as $type => $messages): ?>
<?php foreach ($messages as $message): ?>
<div class="uk-alert uk-alert-<?= $type ?> uk-margin-bottom" data-uk-alert>
<button type="button" class="uk-alert-close uk-close"></button>
<blockquote>
<?= $message; ?>
</blockquote>
</div>
<?php endforeach;?>
<?php endforeach;?>
<?php $session->getFlashBag()->clear(); ?>
<?php if (false === $auth): ?>
<form method="POST" action="<?= BASEURL ?>/login" id="login-form" class="uk-form uk-form-stacked">
<input type="hidden" name="__token__" value="<?= $token ?>">
<div class="uk-margin-bottom">
<input type="text" name="email" class="uk-width-1-1" id="email" placeholder="E-mail address">
<label for="email" class="uk-text-muted uk-text-small">Please enter an e-mail address, which is registered on our website</label>
</div>
<div class="uk-margin-bottom">
<input type="password" name="password" class="uk-width-1-1" id="password" placeholder="Password">
<label for="password" class="uk-text-muted uk-text-small">Please enter a password, associated with e-mail address on our website</label>
</div>
<div class="uk-margin-bottom">
<div id="google-recaptcha" class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
<label for="google-recaptcha" class="uk-text-muted uk-text-small">Please solve "Google recaptcha" challenge</label>
</div>
<button type="submit" class="uk-button uk-button-primary uk-button-large uk-width-1-1">Login</button>
</form>
<?php else: ?>
<form method="POST" action="<?= BASEURL ?>/logout" id="logout-form" class="uk-form">
<input type="hidden" name="__token__" value="<?= $token ?>">
<div class="uk-margin-bottom">
<div id="google-recaptcha-logout" class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
<label for="google-recaptcha-logout" class="uk-text-muted uk-text-small">Please solve "Google recaptcha" challenge</label>
</div>
<button type="submit" class="uk-button uk-button-success uk-button-large uk-width-1-1">Logout</button>
</form>
<?php endif;?>
</div>
</div>
<script src="<?= BASEURL . '/assets/jquery/jquery-3.4.1.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/uikit.min.js'; ?>"></script>
</body>
</html>
