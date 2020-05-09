<?php
namespace App;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use DI\ContainerBuilder;
use FastRoute;

use App\Services\EnvironmentService;
use App\Services\HttpErrorService;
use App\Services\RouterService;

class App
{
    /**
     * DI Container object
     * @var \DI\Container
     */
    private $container;

    /**
     * HttpFoundation Request object
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * HttpFoundation Response object
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private $response;

    /**
     * HttpFoundation Session object
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * Environment object
     * @var \App\Services\EnvironmentService
     */
    private $env;

    /**
     * Current page URI
     * @var string
     */
    private $pageUri;

    /**
     * HTTP methods for CSRF checking
     * @var array
     */
    private $postMethods = [
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ];

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder;
        $containerBuilder->addDefinitions(__DIR__ . '/config/container/di.php');
        $this->container = $containerBuilder->build();
        $this->request   = $this->container->get(Request::class);
        $this->response  = $this->container->get(Response::class);
        $this->session   = $this->container->get(Session::class);
        $this->env       = $this->container->get(EnvironmentService::class);
        $this->pageUri   = $this->request->getPathInfo();
    }

    /**
     * Returns container
     * @return \DI\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Returns base URL, e. g. sheme://host/dir
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->request->getScheme()
        . '://' . $this->request->getHost()
        . $this->request->getBaseUrl();
    }

    /**
     * Verifies necessary mimimum data structure
     * @return void
     */
    public function verifyStructure()
    {
        $siteMeta = $this->env->get('site_inf');
        $menuMeta = $this->env->get('menu_inf');
        $database = $this->env->get('database');
        $databaseData = $this->env->get('database_data');
        $validStructure = (
            true === file_exists($database)
            and true === file_exists($databaseData)
            and true === $this->hasInf($database, $siteMeta)
            and true === $this->hasInf($database, $menuMeta)
        );
        if (false === $validStructure) {
            $this->sendHttpError(503);
        }
    }

    /**
     * Trims input strings
     * @return void
     */
    public function trimStrings()
    {
        foreach ($this->request->request->keys() as $item) {
            $value = trim($this->request->request->get($item));
            $this->request->request->set($item, $value);
        }
    }

    /**
     * Verifies form token
     * @return void
     */
    public function verifyCsrf()
    {
        if (in_array($this->request->getMethod(), $this->postMethods)) {
            $token = $this->request->request->get('__token__');
            $sessionToken = $this->session->get('__token__');
            if (false === ($token === $sessionToken)) {
                $this->sendHttpError(403);
            }
        }
    }

    /**
     * Checks if uri has relies on data directory
     * @return void
     */
    public function verifyDir()
    {
        if (!in_array($this->request->getMethod(), $this->postMethods)) {
            $databaseData = $this->env->get('database_data');
            $frontPage = $this->env->get('front');
            $metaInf = $this->env->get('meta_inf');
            if ('/' === $this->pageUri) {
                $this->pageUri .= '/' . $frontPage;
            }
            if (
                is_dir($databaseData . $this->pageUri)
                and false === $this->hasInf($databaseData . $this->pageUri, $metaInf)
            )
            {
                $this->sendHttpError(403);
            }
        }
    }

    /**
     * Verifies authentification
     * @return void
     */
    public function verifyAuth()
    {
        $segments = array_values(array_filter(explode('/', $this->pageUri)));
        $auth = $this->session->get('auth');
        if (
            !empty(array_intersect($segments, $this->env->get('protected', ['members'])))
            and (false === $auth or null === $auth)
        )
        {
                $controller = $this->container->get('controller.members');
                $content = $this->container->call($controller);
                $this->response->setContent($content);
                $this->response->prepare($this->request);
                $this->response->send();
                exit(0);
        }
    }

    /**
     * If file is not in viewable mime type, sends view or download response
     * @return void
     */
    public function viewOrDownload()
    {
        $database = $this->env->get('database_data');
        $path = $this->pageUri;
        if (is_file($database . $path)) {
            $mime = mime_content_type($database . $path);
            if (!in_array($mime, $this->env->get('contentMime'))) {
                $response = new BinaryFileResponse($database . $path);
                $response->headers->set('Content-Type', $mime);
                if (!in_array($mime, $this->env->get('fileViewable'))) {
                    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, basename($database . $path));
                }
                $response->prepare($this->request);
                $response->send();
                exit(0);
            }
        }
    }

    /**
     * Dispatches uri to controller, gets response from controller and sends it
     * @return void
     */
    public function run()
    {
        $router = $this->container->get(RouterService::class);
        $route = $router->route();
        $content = '';
        switch ($route[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                $this->sendHttpError(404);
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $this->sendHttpError(405);
                break;
            case FastRoute\Dispatcher::FOUND:
                $controller = $route[1];
                $parameters = $route[2];
                $content = $this->container->call($controller, $parameters);
                break;
        }
        $this->response->setContent($content);
        $this->response->prepare($this->request);
        $this->response->send();
        exit(0);
    }

    /**
     * Sends rendered HttpError response
     * @param  integer $status
     * @param  ?string $message
     * @return void
     */
    public function sendHttpError($status, $message = null)
    {
        $this->container->get(HttpErrorService::class)->send($status, $message);
    }

    /**
     * Checks if directory has a meta info file
     * @param  string  $path
     * @param  string  $metaInf
     * @return boolean
     */
    public function hasInf($path, $metaInf = 'meta-inf.xml')
    {
        return file_exists($path . '/' . $metaInf);
    }
}
