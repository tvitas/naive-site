<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

use App\Services\SiteUrlService;
use App\Views\View;

class SitemapController
{
    /**
     * Injected SiteurlService
     * @var \App\Services\SiteUrlService
     */
    private $siteUrlService;

    /**
     * Injected Response object
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private $response;

    /**
     * Injected View object
     * @var \App\Views\View
     */
    private $view;

    public function __construct(SiteUrlService $siteUrlService, Response $response, View $view)
    {
        $this->siteUrlService = $siteUrlService;
        $this->response = $response;
        $this->view = $view;
    }

    /**
     * Creates sitemap xml response and sends it
     * @return void
     */
    public function sitemap()
    {
        $urls = $this->siteUrlService->urls();
        $content = $this->view->render('sitemap/sitemap', ['urls' => $urls], '.xml.php');
        $this->response->headers->set('Content-Type', 'text/xml');
        $this->response->setContent($content);
        $this->response->send();
        exit(0);
    }
}
