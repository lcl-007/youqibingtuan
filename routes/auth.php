<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\WxloginController;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1',['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function($api){
    //路由组
$api->group(['prefix'=>'auth'],function($api){
    //注册
    $api->post('register',[RegisterController::class,'store']);
    //登录
    $api->any('login',[LoginController::class,'login']);
    //获取用户信息
    $api->post('me',[LoginController::class,'me']);
    // //wxtest
    // $api->get('wechat',[WxloginController::class,'userAuth']);
});
}); 