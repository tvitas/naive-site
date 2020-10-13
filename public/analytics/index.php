<?php
define('AWSTATS_URL', 'https://webhub.lsmuni.lt/awstats/awstats.pl?config=');

// Redirect to awstats analytics page
redirect(AWSTATS_URL . $_SERVER['HTTP_HOST'], 301);

function redirect($route, $status = 302, $replace = true)
{
    header('Location: ' . $route, $replace, $status);
    die();
}

