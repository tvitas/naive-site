<?php
namespace App\Views;
use App\Services\EnvironmentService;

class View
{
    const TEMPLATE_NOT_FOUND = 'Template not found.';

    /**
     * Injected Environment object
     * @var \App\Services\EnvironmentService
     */
    private $env;

    public function __construct(EnvironmentService $env)
    {
        $this->env = $env;
    }

    /**
     * Renders template in output buffer
     * @param  string $template  which template to render
     * @param  array  $variables
     * @return string rendered html markup
     */
    public function render($template, $variables = [], $templateSuffix = '.html.php')
    {
        $template = __DIR__ . '/../..'
        . '/' . $this->env->get('views', 'resources/views')
        . '/' . $template . $templateSuffix;

        if (false === file_exists($template)) {
            return self::TEMPLATE_NOT_FOUND;
        }

        ob_start();
        extract($variables);
        include $template;
        return ob_get_clean();
    }
}
