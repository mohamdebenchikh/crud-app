<?php

namespace App\Core;

class Redirect
{
    protected $url;

    public function to($url)
    {
        $this->url = $url;
        return $this;
    }

    public function back()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        return $this->to($referer);
    }

    public function with($key,$value)
    {
        Session::setFlash($key,$value);
        return $this;
    }

    public function withErrors(array $errors)
    {
        return $this->with('errors',$errors);
    }

    public function withInputs(array $data)
    {
        return $this->with('inputs',$data);
    }

    public function __destruct()
    {
        header("Location: {$this->url}");
        exit;
    }

}