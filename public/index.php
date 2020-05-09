<?php
require __DIR__ . '/../vendor/autoload.php';
use App\App;

define('BASEPATH', __DIR__ . '/..');
define('APPPATH', __DIR__ . '/../app');

$app = new App();
define('BASEURL', $app->getBaseUrl());

// boot sequention
$app->trimStrings();
$app->verifyCsrf();
$app->verifyStructure();
$app->verifyDir();
$app->verifyAuth();
$app->viewOrDownload();
// run :)
$app->run();

