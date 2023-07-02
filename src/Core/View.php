<?php

namespace App\Core;

class View
{
    protected $layout = "main";
    protected $params = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    public function component($component, $params = [])
    {
        $componentPath = ROOT_DIR  . '/src/views/components/' . $component . '.php';
        ob_start();
        extract($params, EXTR_SKIP);
        require $componentPath;
        return ob_get_clean();
    }

    public function render($view, $params = [])
    {
        $this->params = $params;
        $content = $this->renderView($view);
        $this->params['content'] = $content;
        return $this->renderView("layouts/{$this->layout}");
    }


    protected function renderView($view)
    {
        ob_start();
        extract($this->params, EXTR_SKIP);
        require ROOT_DIR  . '/src/views/' . $view . '.php';
        return ob_get_clean();
    }

}
