<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

use Urodoz\Truncate\TruncateService;

use tvitas\SiteRepo\Traits\XpathQueryTrait;
use tvitas\FileCache\FileCache;
use tvitas\SiteRepo\SiteRepo;


use App\Services\EnvironmentService;
use App\Services\HttpErrorService;
use App\Traits\RandomStringTrait;
use App\Views\View;


abstract class BaseController
{
    use XpathQueryTrait;

    use RandomStringTrait;

    /**
     * Injected Environment object
     * @var \App\Services\EnvironmentService
     */
    protected $env;

    /**
     * Injected HttpFoundtion Request object
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Injected HttpFoundtion Session object
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * Injected SiteRepo object
     * @var \tvitas\SiteRepo\SiteRepo
     */
    protected $repo;

    /**
     * Injected View object
     * @var \App\Views\View
     */
    protected $view;

    /**
     * Injected HttpErrorService object
     * @var \App\Services\HttpErrorService
     */
    protected $httpError;

    /**
     * Injected TruncateService object
     * @var \Urodoz\Truncate\TruncateService
     */
    protected $truncator;

    /**
     * Injected file FileCache object
     * @var \tvitas\FileCache\FileCache
     */
    protected $cache;

    /**
     * Current URI
     * @var string
     */
    protected $pageUri;

    /**
     * For the XpathQueryTrait
     * @var string
     */
    protected $metaInf;

    /**
     * Directory meta data
     * @var \tvitas\SiteRepo\Collections\NaiveArrayList
     */
    protected $meta;

    /**
     * Site meta data
     * @var \tvitas\SiteRepo\Collections\NaiveArrayList
     */
    protected $site;

    /**
     * Rendered secondary menu
     * @var string
     */
    protected $menuSecondary;

    /**
     * Rendered nav menu
     * @var string
     */
    protected $menuNav;

    /**
     * Rendered page header
     * @var string
     */
    protected $pageHeader;

    /**
     * Rendered "TopMost" block
     * @var string
     */
    protected $pageTopmost;

    /**
     * Raw page data
     * @var \tvitas\SiteRepo\Collections\NaiveArrayList
     */
    protected $pageContentRaw;

    /**
     * Rendered page content
     * @var string
     */
    protected $pageContent;

    /**
     * Rendered page footer
     * @var string
     */
    protected $pageFooter;

    /**
     * Rendered offcanvas menu
     * @var string
     */
    protected $menuOffcanvas;

    /**
     * Current layout templates dir
     * @var string
     */
    protected $layout;

    public function __construct(
        HttpErrorService $httpErrorService,
        EnvironmentService $environment,
        TruncateService $truncator,
        Session $session,
        Request $request,
        SiteRepo $repo,
        View $view,
        FileCache $cache
    )

    {
        $this->env = $environment;
        $this->request = $request;
        $this->session = $session;
        $this->repo = $repo;
        $this->view = $view;
        $this->httpError = $httpErrorService;
        $this->truncator = $truncator;
        $this->cache = $cache;
        $this->pageUri = $this->request->getPathInfo();
        $this->layout = $this->env->get('layout', 'default');
        $this->metaInf = $this->env->get('menu_inf', 'menu-inf.xml');
    }

    /**
     * Returns fresh or cached page
     * @return string HTML markup
     */
    protected function getPage()
    {
        $page = '';
        $cacheKey = hash('md5', $this->pageUri);
        if ($this->env->get('cache', false)) {
            if ($this->cache->has($cacheKey) and false === $this->session->get('auth')) {
                $page = $this->cache->get($cacheKey);
            } else {
                $this->buildPage();
                $page = $this->show();
                $this->cache->set($cacheKey, $page);
            }
        } else {
            $this->buildPage();
            $page = $this->show();
        }
        return $page;
    }

    /**
     * Collection of variables for using in the page
     * @return void
     */
    protected function buildPage()
    {
        $this->existsOrFail($this->pageUri);
        $this->pageContentRaw = $this->repo->content()->get()->sort('order', 'asc');

        $token = $this->randomString();
        $this->session->set('__token__', $token);

        $this->meta = $this->repo->meta()->get()->first();
        $this->site = $this->repo->site()->get()->first();

        $topmost = $this->getBlock($this->env->get('topmost'));
        $header = $this->getBlock($this->env->get('header'));
        $footer = $this->getBlock($this->env->get('footer'));

        $nav = $this->repo->menu()->byType('nav');
        $secondary = $this->repo->menu()->byType('secondary');
        $menu = $this->repo->menu();
        $offcanvas = $this->repo->menu()->get();

        $this->menuSecondary = $this->layout(
            $secondary->getTemplate(), 'menus/',
            [
                'secondary' => $secondary,
                'pageUri' => $this->pageUri,
                'session' => $this->session,
                'token' => $token,
            ]
        );

        $this->pageHeader = $this->layout(
            'header', 'headers/',
            [
                'header' => $header,
                'site' => $this->site,
            ]
        );

        $this->menuNav = $this->layout(
            $nav->getTemplate(), 'menus/',
            [
                'nav' => $nav,
                'pageUri' => $this->pageUri,
            ]
        );

        $this->pageTopmost = $this->layout(
            'top', 'tops/',
            [
                'truncator' => $this->truncator,
                'top' => $topmost,
                'pageUri' => $this->pageUri,
            ]
        );

        $this->pageContent = $this->layout(
            $this->meta->getTemplate(), 'content/',
            [
                'html' => $this->pageContentRaw,
                'meta' => $this->meta,
                'truncator' => $this->truncator,
                'pageUri' => $this->pageUri,
            ]
        );

       $this->menuOffcanvas = $this->layout(
            $menu->byType('offcanvas')->getTemplate(), 'menus/',
            [
                'offcanvas' => $offcanvas,
                'pageUri' => $this->pageUri,
                'session' => $this->session,
            ]
        );

        $this->pageFooter = $this->layout(
            'footer', 'footers/',
            [
                'footer' => $footer,
            ]
        );
    }

    /**
     * Returns rendered page
     * @return string rendered page
     */
    protected function show()
    {
        return $this->view->render($this->layout . '/page',
            [
                'meta' => $this->meta,
                'site' => $this->site,
                'menuSecondary' => $this->menuSecondary,
                'menuNav' => $this->menuNav,
                'pageHeader' => $this->pageHeader,
                'pageTopmost' => $this->pageTopmost,
                'pageContent' => $this->pageContent,
                'pageFooter' => $this->pageFooter,
                'menuOffcanvas' => $this->menuOffcanvas,
            ]
        );
    }

    /**
     * Compares uri and databse path
     * @param  string $path page uri
     * @return void
     */
    protected function existsOrFail($path)
    {
        if (false === file_exists($this->env->get('database_data') . '/' . $path)) {
            $this->httpError->send(404);
        }
    }

    /**
     * Returns block data
     * @param  string $path block dir
     * @return ?\tvitas\SiteRepo\Collections\NaiveArrayList
     */
    protected function getBlock($path = 'topmost')
    {
        $currentPath = $this->repo->getPath();
        $block = null;
        $blocks = [
            $currentPath . '/' . $path,
            $this->env->get('database_data') . '/' . $path
        ];
        foreach ($blocks as $blockPath) {
            if (true === file_exists($blockPath)) {
                $this->repo->setFullPath($blockPath);
                $block = $this->repo->content()->get()->sort('order', 'asc');
                break;
            }
        }
        $this->repo->setFullPath($currentPath);
        return $block;
    }

    /**
     * Finds template file name and renders template
     * @param  string $template
     * @param  string $templateLocation
     * @param  array $data
     * @return string
     */
    protected function layout($template, $templateLocation, $data)
    {
        $segments  = array_filter(explode('/', $this->pageUri));
        $uriPrefix = implode('--', $segments);
        $rendered = '';
        ('' === $uriPrefix) ? $uriPrefix = $this->env->get('front') : null;
        $templates = [
                $this->layout  .'/' . $templateLocation . $template . '_' . $uriPrefix,
                $this->layout . '/' . $templateLocation . $template,
            ];
        foreach ($templates as $template) {
            $rendered = $this->view->render($template, $data);
            if (View::TEMPLATE_NOT_FOUND !== $rendered) {
                break;
            }
        }
        return $rendered;
    }
}
