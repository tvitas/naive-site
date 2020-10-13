<?php
namespace App\Traits;
use Symfony\Component\HttpFoundation\RedirectResponse;

trait RedirectToTrait
{

    public function redirectTo($to = BASEURL . '/login')
    {
        $response = new RedirectResponse($to);
        $response->prepare($this->request);
        $response->send();
        exit(0);
    }
}
