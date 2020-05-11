<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class SiteController extends BaseController
{
    /**
     * Runs controller
     * @return string page html markup
     */
    public function __invoke()
    {
        ('/' === $this->pageUri) ? $front = $this->env->get('front') : $front = '';
        $this->repo->setPath($this->pageUri . $front);
        $this->pageUri = $this->pageUri . $front;
        $page = '';
        $cacheKey = hash('md5', $this->pageUri);
        if ($this->env->get('cache', false)) {
            if ($this->cache->has($cacheKey)) {
                $page = $this->cache->get($cacheKey);
            } else {
                $this->buildPage();
                $page = $this->show();
                $this->cache->set($cacheKey, $page, $this->env->get('cache_ttl', 300));
            }
        } else {
            $this->buildPage();
            $page = $this->show();
        }
        return $page;
    }
}
