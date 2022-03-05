<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use App\Models\Good;
use App\Models\slide;

class IndexController extends BaseController
{

    public function index()
    {
         //轮播图数据
    $slides = slide::where('status',1)
    ->orderBy('seq')
    ->get();
    //分类数据
    $categories = cache_category();
    //推荐商品
    $goods= Good::where('is_on',1)
    ->where('is_recommend',1)
    ->take(20)
    ->get();

    return $this->response->array([
        'slides' => $slides,
        'categories'=>$categories,
        'goods'=>$goods
    ]);
    }

}
