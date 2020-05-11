<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Traits\RedirectToTrait;

class MembersController extends BaseController
{
    use RedirectToTrait;

    /**
     * Runs controller
     * @return string page html markup
     */
    public function __invoke()
    {
        if (null === $this->session->get('auth') or false === $this->session->get('auth')) {
            $this->session->set('get_in', $this->pageUri);
            $this->redirectTo();
        }
        $this->repo->setPath($this->pageUri);
        return $this->getPage();
    }
}
