<?php

namespace App\Core;

class Request
{
    public function path()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        // Remove the base path from the request URI
        if (substr($uri, 0, strlen(BASE_PATH)) === BASE_PATH) {
            $uri = substr($uri, strlen(BASE_PATH));
        }

        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }

        $uri = $uri === "/"  ? $uri : rtrim($uri, '/');

        return $uri;
    }

    public function method()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $allowedMethods = ['PUT', 'DELETE'];

        if ($method === 'POST' && isset($_POST['_METHOD']) && in_array($_POST['_METHOD'], $allowedMethods, true)) {
            return strtoupper($_POST['_METHOD']);
        }

        return strtoupper($method);
    }

    public function body()
    {
        $data = [];
        if ($this->isMethod('POST') || $this->isMethod('PUT')) {
            $postData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            foreach ($postData as $key => $value) {
                $data[$key] = $value;
            }
        }

        $queryParameters = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?: [];
        foreach ($queryParameters as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    public function input($key)
    {
        $body = $this->body();
        return $body[$key] ?? null;
    }


    public function isMethod(string $method)
    {
        return $method === $this->method();
    }

    public function hasFile(string $name)
    {
        return isset($_FILES[$name]) && is_uploaded_file($_FILES[$name]['tmp_name']);
    }

    public function file(string $name)
    {
        if ($this->hasFile($name)) {
            return $_FILES[$name];
        }

        return null;
    }
}
