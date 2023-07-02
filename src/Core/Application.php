<?php

namespace App\Core;

class Application
{

    protected array $routes = [];
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get($path, $callback)
    {
        $route = new Route($path, $callback);
        $this->routes['GET'][] = $route;
        return $route;
    }

    public function post($path, $callback)
    {
        $route = new Route($path, $callback);
        $this->routes['POST'][] = $route;
        return $route;
    }

    public function put($path, $callback)
    {
        $route = new Route($path, $callback);
        $this->routes['PUT'][] = $route;
        return $route;
    }

    public function delete($path, $callback)
    {
        $route = new Route($path, $callback);
        $this->routes['DELETE'][] = $route;
        return $route;
    }

    public function run()
    {
        $path = $this->request->path();
        $method = $this->request->method();

        foreach($this->routes[$method] as $route){
            if($route->match($path)){
                $result = $route->execute();
                echo $result;
                return;
            }
        }

        http_response_code(404);
        echo (new View())->render('errors/404');
        exit;
    }
}
