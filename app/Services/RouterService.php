<?php
namespace App\Services;
use Symfony\Component\HttpFoundation\Request;

class RouterService
{
    /**
     * Injected FastRoute Dispatcher object
     * @var \FastRoute\Dispatcher
     */
    private $dispatcher;

    /**
     * Injected HttpFoundation Request object
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->dispatcher = require __DIR__ . '/../config/routes/routes.php';
    }

    /**
     * Returns array.
     * @see \FastRoute\Dispatcher
     * @return array
     */
    public function route()
    {
        $route = $this->dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());
        return $route;
    }
}
