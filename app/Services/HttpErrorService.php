<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Views\View;

class HttpErrorService
{
    /**
     * Injected HttpFoundation Response object
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private $response;

    /**
     * Injected HttpFoundation Request object
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Injected View object
     * @var \App\Views\View
     */
    private $view;

    public function __construct(Response $response, Request $request, View $view)
    {
        $this->response = $response;
        $this->request = $request;
        $this->view = $view;
    }


    /**
     * Sends Http Status response
     * @param  integer $status  Http status code
     * @param  string  $message Optional own status message
     * @return void
     */
    public function send($status, $message = null)
    {
        if (null === $message) {
            $message = $this->response::$statusTexts[$status];
        }
        $this->response->setStatusCode($status, $message);
        $this->response->setContent(
            $this->view->render('status/http_status',
                [
                    'status' => $status,
                    'message' => $message,
                ]
            )
        );
        $this->response->prepare($this->request);
        $this->response->send();
        exit($status);
    }
}
