<?php
return [
    // On each request build configuration array
    'app.autoconfig' => function() {
        $confs = array_values(array_diff(scandir(__DIR__ . '/../../config'), ['.', '..']));
        $confs = array_filter($confs,
            function($item)
            {
                return is_file(__DIR__ . '/../../config' . '/' . $item);
            }
        );
        return $confs;
    },
    // Logging
    'app.logfile' => __DIR__ . '/../../../resources/var/log/app.log',
    // Caching
    'app.cachedir' => __DIR__ . '/../../../resources/var/cache',
    'app.cachettl' => 600,
    // Protected controller
    'controller.members' => 'App\Controllers\MembersController',
    // Autowiring HttpFoundation
    'Symfony\Component\HttpFoundation\Request' => function() {
        return Symfony\Component\HttpFoundation\Request::createFromGlobals();
    },
    'Symfony\Component\HttpFoundation\Response' => DI\autowire(),
    'Symfony\Component\HttpFoundation\RedirectResponse' => DI\autowire(),
    'Symfony\Component\HttpFoundation\Session\Session' => DI\autowire(),
    // Autowiring app
    'App\Services\SiteUrlService' => DI\autowire(),
    'App\Services\RouterService' => DI\autowire(),
    'App\Services\HttpErrorService' => DI\autowire(),
    'App\Services\EnvironmentService' => DI\autowire()
        ->constructorParameter('items', DI\get('app.autoconfig')),
    // Autowiring logger
    'tvitas\NaiveLogger\NaiveLogger' => DI\autowire()
        ->constructorParameter('logFile', DI\get('app.logfile')),
    // Autowiring file cache
    'tvitas\FileCache\FileCache' => DI\autowire()
        ->constructorParameter('cacheDir', DI\get('app.cachedir'))
        ->constructorParameter('ttl', DI\get('app.cachettl')),
    // Autowiring site repo
    'tvitas\SiteRepo\SiteRepo' => function() {
        tvitas\SiteRepo\Environment::getInstance()->load(__DIR__ . '/../../config/site-repo.php');
        return new tvitas\SiteRepo\SiteRepo();
    },
];
