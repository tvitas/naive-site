<?php
namespace App\Services;
use App\Services\EnvironmentService;
use App\App;

class SiteUrlService
{
    /**
     * Injected EnvironmentService
     * @var \App\Services\EnvironmentService
     */
    private $env;

    /**
     * Injected App
     * @var \App\App
     */
    private $app;

    public function __construct(EnvironmentService $env, App $app)
    {
        $this->env = $env;
        $this->app = $app;
    }

    /**
     * Generates urls for sitemap
     * @return array urls for sitemap
     */
    public function urls()
    {
        $reservedNames = $this->env->get('reservedNames', []);
        $databaseData = $this->env->get('database_data', '');
        $protected = $this->env->get('protected', []);
        $baseUrl = $this->app->getBaseUrl();
        $checks = array_merge($reservedNames, $protected);
        $urls = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($databaseData, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST,
                \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($iterator as $path => $dir) {
            $segments = array_values(array_filter(explode('/', $path)));
            if (empty(array_intersect($segments, $checks))) {
                $urls[] = str_replace($databaseData, $baseUrl, $path);
            }
        }
        return $urls;
    }
}
