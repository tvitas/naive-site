<?php
namespace App\Services;

class EnvironmentService
{
    /**
     * Associative array of config items
     * @var array
     */
    private $config = [];

    public function __construct($items = [])
    {
        foreach ($items as $item) {
            $this->config += require __DIR__ . '/../config' . '/' . $item;
        }
    }

    /**
     * Returns config array item, if key exists
     * @param  string $key     config item key
     * @param  mixed  $default value if config item does not exists
     * @return ?mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : $default;
    }
}
