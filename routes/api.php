<?php

use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CommentController;
use App\Http\Controllers\api\GoodsController;
use App\Http\Controllers\api\IndexController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\Api\PayController;
use App\Http\Controllers\api\UserController as ApiUserController;

$api = app('Dingo\Api\Routing\Router');

$params = ['middleware'=>
    ['api.throttle',//访问节流器（1分钟可以登录60次）
    'binding',//路由模型注入
  ],
    'limit' => 60,
    'expires' => 1];

$api->version('v1',$params,function($api){


  // $api->any('/wechat',[WechatController::class,'serve']);
  //后台主页
$api->get('admin',[ApiUserController::class,'admin']);

$api->get('index',[IndexController::class,'index']);
/**
 * 商品
 */
//商品详情
$api->get('goods/{good}',[GoodsController::class,'show']);
//商品列表
$api->get('goods',[GoodsController::class,'index']);
//需要登陸的路由
$api->group(['middleware'=>'api.auth'],function($api){
  /**
   * 个人中心 
   */
  //充值
  $api->post('wcinsert',[ApiUserController::class,'wcinsert']);
//钱包余额
$api->get('balance',[ApiUserController::class,'balance']);
  //积分商城
  $api->get('integral_shop',[ApiUserController::class,'integral_shop']);
  //用户详情
  $api->get('user',[ApiUserController::class,'userInfo']);
  //更新个人信息
  $api->put('user',[ApiUserController::class,'updateUserInfo']);
  //更新头像
  $api->patch('user/avatar',[ApiUserController::class,'avatarUpdate']);
  /**
   * 购物车
   */
  $api->resource('carts',CartController::class,[
    'except'=>['show']
  ]);
  /**
 * 订单 
 */
//订单管理
$api->get('no',[OrderController::class,'orderlist']);
//提交订单
$api->post('orders',[OrderController::class,'store']);
//订单详情
$api->get('show',[OrderController::class,'show']);
//订单列表
$api->get('orders',[OrderController::class,'index']);
//确认收货
$api->patch('orders/{order}/confirm',[OrderController::class,'confirm']);
//商品评论
$api->post('orders/{order}/comment',[CommentController::class,'store']);
//我的评论
$api->get('mycomment',[CommentController::class,'mycomment']);

/**
 * 支付 
 */
$api->get('pay',[PayController::class,'WeChatPay']);
 });

});