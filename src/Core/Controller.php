<?php

namespace App\Core;


abstract class Controller
{
    protected Request $request;
    protected View $view;

    public function __construct()
    {
        $this->request = new Request();
        $this->view = new View();
    }
}
