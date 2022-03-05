<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GoodsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;

$api = app('Dingo\Api\Routing\Router');

$params = ['middleware'=>
    ['api.throttle',//访问节流器（1分钟可以登录60次）
    'binding',//路由模型注入
    ],
    'limit' => 60,
    'expires' => 1];
//版本v1
$api->version('v1',$params,function($api){
//url前缀为admin
$api->group(['prefix'=>'admin'],function($api){

    //需要登录
$api->group(['middleware'=>['api.auth']],function($api){
        //用户列表
$api->get('indexlist',[UserController::class,'index']);
     //用户细节
$api->get('user/{user}/show',[UserController::class,'show']);
 //禁用用户/启用用户
$api->patch('users/{user}/lock',[UserController::class,'is_lock'])->name('users.lock');
//添加优惠券
$api->post('create_coupon',[UserController::class,'create_coupon']);
//是否启用优惠券
$api->patch('coupon/{coupon}/ison',[UserController::class,'isOn']);




/**
 * 分类管理
 */
$api->patch('category/{category}/status',[CategoryController::class,'status'])->name('category.status');
//分类列表
$api->get('category',[CategoryController::class,'index']);
//添加分类
$api->post('category/store',[CategoryController::class,'store']);
//分类详情
$api->get('category/{category}/show',[CategoryController::class,'show']);
//更新分类
$api->post('category/update',[CategoryController::class,'update']);
 
 /**
     * 商品管理
     */
//是否上架
$api->patch('goods/{good}/on',[GoodsController::class,'isOn'])->name('goods.on');

//是否推荐
$api->patch('goods/{good}/recommend',[GoodsController::class,'isRecommend'])->name('goods.recommend');

//商品管理资源路由
$api->resource('goods',GoodsController::class,
['except'=>['destroy']
]);

/**
     * 评价管理
     */
    $api->get('comments',[CommentController::class,'index'])->name('comments.index');
    //评价详情
    $api->get('comments/{comment}',[CommentController::class,'show'])->name('comments.show');
    //回复评价
    $api->patch('comments/{comment}/reply',[CommentController::class,'reply'])->name('comments.reply');


    /**
     * 订单管理
     */
    //订单列表
    $api->get('orders',[OrderController::class,'index'])->name('order.index');
    //订单详情
    $api->get('orders/{order}',[OrderController::class,'show'])->name('order.show');
    //订单发货
    $api->patch('orders/{order}/post',[OrderController::class,'post'])->name('order.post');
/**
     * 轮播图管理
     * */
    $api->resource('slides',SlideController::class);
    /**
     * 排序
     */
    $api->patch('slides/{slide}/seq',[SlideController::class,'seq'])->name('slides.seq');
    /**
     * 轮播图禁用和启用
     */
    $api->patch('slides/{slide}/status',[SlideController::class,'status'])->name('slides.status');

} );
 }
 );
});
  