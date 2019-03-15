<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/user/login','User\IndexController@login');//用户登录
$router->get('/user/center','User\IndexController@userCenter');//用户中心
$router->get('/user/order','User\IndexController@order');