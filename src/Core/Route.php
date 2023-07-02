<?php

namespace App\Core;

class Route
{
    protected string $path;
    protected $callback;
    protected array $params = [];

    public function __construct(string $path, $callback)
    {
        $this->path = $path;
        $this->callback = $callback;
    }

    public function match(string $path): bool
    {
        $pattern = preg_replace('/{([a-zA-Z0-9_]+)}/', '([^/]+)', $this->path);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';

        if (preg_match($pattern, $path, $matches)) {
            array_shift($matches);
            $this->params = $this->extractParams($matches);
            return true;
        }

        return false;
    }

    protected function extractParams(array $matches): array
    {
        $params = [];

        preg_match_all('/{([a-zA-Z0-9_]+)}/', $this->path, $paramNames);

        foreach ($paramNames[1] as $index => $paramName) {
            $params[$paramName] = $matches[$index];
        }

        return $params;
    }

    public function execute()
    {
        $callback = $this->callback;

        if (is_array($callback) && count($callback) === 2) {
            [$controller, $method] = $callback;

            if (is_string($controller) && class_exists($controller)) {
                $controllerInstance = new $controller();

                if (is_callable([$controllerInstance, $method])) {
                    return call_user_func_array([$controllerInstance, $method], array_values($this->params));
                }
            }
        }

        return call_user_func_array($callback, array_values($this->params));
    }
}
