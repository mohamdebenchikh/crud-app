<?php


require dirname(__DIR__)."/vendor/autoload.php";

use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Core\Application;
use App\Core\Session;

Session::start();

$app = new Application();

$app->get('/',[HomeController::class,'index']);
$app->get('/products',[ProductController::class,'index']);
$app->get('/products/create',[ProductController::class,'create']);
$app->post('/products',[ProductController::class,'store']);
$app->get('/products/{id}/edit',[ProductController::class,'edit']);
$app->put('/products/{id}',[ProductController::class,'update']);
$app->delete('/products/{id}',[ProductController::class,'delete']);

$app->run();