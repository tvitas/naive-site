<?php
namespace App\Controllers\Auth;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

use tvitas\SiteRepo\SiteRepo;
use tvitas\NaiveLogger\NaiveLogger;

use App\Services\EnvironmentService as Env;
use App\Traits\VerifyRecaptchaTrait;
use App\Traits\RandomStringTrait;
use App\Traits\RedirectToTrait;
use App\Views\View;

class AuthController
{
    use RandomStringTrait;

    use RedirectToTrait;

    use VerifyRecaptchaTrait;

    /**
     * Injected request object
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Injected Session object
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * Injected Environment object
     * @var \App\Services\EnvironmentService
     */
    private $env;

    /**
     * Injected View object
     * @var \App\Views\View
     */
    private $view;

    /**
     * Injected Rpository object
     * @var \tvitas\SiteRepo\SiteRepo
     */
    private $repo;

    /**
     * Injected NaiveLogger object
     * @var \tvitas\NaiveLogger\NaiveLogger
     */
    private $logger;

    public function __construct
    (
        Request $request,
        Session $session,
        SiteRepo $repo,
        NaiveLogger $logger,
        Env $env,
        View $view
    )
    {
        $this->request = $request;
        $this->session = $session;
        $this->view = $view;
        $this->repo = $repo;
        $this->logger = $logger;
        $this->env = $env;
    }

    /**
     * Returns rendered login form
     * @return string rendered login form
     */
    public function login()
    {
        $loginForm = '';
        $auth = $this->session->get('auth', false);
        $site = $this->repo->site()->get()->first();
        $siteKey = $this->env->get('recaptcha_site');
        $token = $this->randomString();
        $this->session->set('__token__', $token);
        $loginForm = $this->view->render(
            $this->env->get('layout') . '/auth/login_form',
                [
                    'token' => $token,
                    'auth' => $auth,
                    'site' => $site,
                    'site_key' => $siteKey,
                    'session' => $this->session,
                ]
            );
        return $loginForm;
    }

    /**
     * Sets auth and user to false and redirects to front
     * @return void
     */
    public function logout()
    {
        $this->session->set('auth', false);
        $this->logger->info('User {user} logged out.', ['user' => $this->session->get('user')['name']]);
        $this->session->set('user', null);
        $this->redirectTo('/');
    }

    /**
     * Verifies credentials and recaptcha
     * Redirects to login uri if credentials or recaptcha fail
     * Redirects to uri, saved in session if credentials and recaptcha not fail
     * @return void
     */
    public function verify()
    {
        $inputEmail     = strtolower($this->request->request->get('email'));
        $inputPassword  = $this->request->request->get('password');
        $flashBag = $this->session->getFlashBag();

        $user = $this->repo->user();
        if (
            null === $user
            or null === $user->byEmail($inputEmail)
            or '' === $inputPassword
            or '' === $inputEmail
            or false === filter_var($inputEmail, FILTER_VALIDATE_EMAIL)
            or false === $this->verifyRecaptcha()
        )
        {
            $flashBag->add('danger','Bad credentials.');
            if (false === $this->verifyRecaptcha()) {
                $flashBag->add('warning', 'Please solve „Google recaptcha“ challenge.');
            }
            $this->logger->warning('Invalid login attempt {email}, {pass}.', ['email' => $inputEmail, 'pass' => $inputPassword]);
            $this->redirectTo();
        }

        $verifiedUser = $user->byEmail($inputEmail);
        $passwordHash = $verifiedUser->getPassword();

        if (true === password_verify($inputPassword, $passwordHash)) {
            $this->session->set('auth', true);
            $this->session->set('user',
                [
                    'name' => $verifiedUser->getName(),
                    'email' => $verifiedUser->getEmail(),
                    'description' => $verifiedUser->getDescription(),
                ]
            );
            $this->logger->info('User {user} logged in.', ['user' => $this->session->get('user')['name']]);
            $this->redirectTo($this->session->get('get_in', '/'));
        }
        $this->redirectTo();
    }
}
