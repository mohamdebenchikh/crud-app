<?php

use App\Core\Redirect;
use App\Core\Request;
use App\Core\Session;

function request()
{
    return new Request();
}

function redirect()
{
    return new Redirect();
}

function session()
{
    return new Session();
}

function error($error)
{
    $errors = session()->hasFlash('errors') ? session()->getFlash('errors') : [];
    return isset($errors[$error]) ? $errors[$error][0] : false;
}

function old($input)
{
    $inputs = session()->hasFlash('inputs') ? session()->getFlash('inputs') : [];
    return isset($inputs[$input]) ? $inputs[$input] : null;
}


// Inside your view class or helper functions file
function isActive($url)
{
    $currentPath = request()->path();
    return url("$currentPath") === $url ? 'active' : '';
}


function url($path){
    return APP_URL.$path;
}