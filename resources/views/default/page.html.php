<?php $metaDescription = $meta->getDescription(); ?>
<?php $metaTitle = $meta->getTitle(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="pU0tbrXdBHuHOeJJc4J_vJIf3aSHH4s9Sx5Zhwu6I_c" />
<?php if ($metaDescription): ?>
<meta name="description" content="<?= $metaDescription ?>">
<?php endif;?>
<title><?= $site->getName() ?><?php if ($metaTitle): ?> | <?= $metaTitle ?><?php endif;?></title>
<link href="<?= BASEURL . '/assets/uikit/css/uikit.almost-flat.min.css' ?>" rel="stylesheet">
<link href="<?= BASEURL . '/assets/uikit/css/components/sticky.almost-flat.min.css' ?>" rel="stylesheet">
<link href="<?= BASEURL . '/assets/uikit/css/components/dotnav.almost-flat.min.css' ?>" rel="stylesheet">
<link href="<?= BASEURL . '/assets/uikit/css/components/slidenav.almost-flat.min.css' ?>" rel="stylesheet">
<link href="<?= BASEURL . '/assets/uikit/css/components/accordion.almost-flat.min.css' ?>" rel="stylesheet">
<link href="<?= BASEURL . '/assets/css/cccf.css' ?>" rel="stylesheet">
</head>
<body>

<?php /*Top navigation: secondary*/ ?>
<?= $menuSecondary ?? ''; ?>

<?php /*Page header*/ ?>
<?= $pageHeader ?? ''; ?>

<?php /*Navigation: nav*/?>
<div id="navigation">
<nav class="uk-navbar uk-navbar-attached" data-uk-sticky="{top: -50}">
<?php /*Hamburger and Brand*/?>
<div class="uk-visible-small uk-navbar-content">
<a href="#offcanvas-bar" class="uk-navbar-toggle" data-uk-offcanvas></a>
<a href="<?= BASEURL ?>" class="uk-navbar-brand" title="<?= $site->getSlogan() ?>"><?= $site->getAcronym() ?></a>
</div>
<div id="navigation-nav" class="uk-hidden-small uk-container uk-container-center">
<?= $menuNav ?? ''; ?>
</div>
</nav>
</div>

<?php /*Top most*/ ?>
<?= $pageTopmost ?? ''; ?>

<?php /*Content*/ ?>
<?= $pageContent ?? ''; ?>


<?php /*Footer*/ ?>
<?= $pageFooter ?? ''; ?>

<?php /*Offcanvas*/?>
<?= $menuOffcanvas ?? ''; ?>

<script src="<?= BASEURL . '/assets/jquery/jquery-3.4.1.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/uikit.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/components/grid.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/components/accordion.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/components/sticky.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/components/slideset.min.js'; ?>"></script>
<script src="<?= BASEURL . '/assets/uikit/js/components/lightbox.min.js'; ?>"></script>
</body>
</html>
