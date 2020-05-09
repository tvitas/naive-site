<?php
$dispatcher = FastRoute\simpleDispatcher(
    function(FastRoute\RouteCollector $route)
    {
        $siteController = 'App\Controllers\SiteController';
        $privateController = 'App\Controllers\MembersController';
        $authController = 'App\Controllers\Auth\AuthController';
        // Sitemap
        $route->get('/sitemap', ['App\Controllers\SitemapController', 'sitemap']);
        // Private
        $route->get('/members', $privateController);
        $route->get('/members/[{a:[a-zA-Z0-9.\-]+}[/{b:[a-zA-Z0-9.\-]+}[/{c:[a-zA-Z0-9.\-]+}]]]', $privateController);
        // Authentificate
        $route->get('/login',  [$authController, 'login']);
        $route->post('/logout', [$authController, 'logout']);
        $route->post('/login', [$authController, 'verify']);
        // Site
        $route->get('/[{a:[a-zA-Z0-9.\-]+}[/{b:[a-zA-Z0-9.\-]+}[/{c:[a-zA-Z0-9.\-]+}]]]', $siteController);
    }
);
return $dispatcher;
