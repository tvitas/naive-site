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
        $this->buildPage();
        return $this->show();
    }
}
