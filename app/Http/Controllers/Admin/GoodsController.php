<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\category;
use App\Models\Good;
use App\Transformers\GoodsTransformer;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //搜索及查询列表
        $title = $request->query('title');
        $category_id = $request->query('category_id');
        $is_on = $request->query('is_on',false);
        $is_recomment = $request->query('is_recomment',false);

        $Goods = Good::when($title,function($query)use($title){
            $query->where('title','like',"%$title%");
        })->when($category_id,function($query)use($category_id){
            $query->where('category_id',$category_id);
        })->when($is_on !==false,function($query)use($is_on){
            $query->where('is_on',$is_on);
        })->when($is_recomment !==false,function($query)use($is_recomment){
            $query->where('is_recomment',$is_recomment);
        })->paginate();

        return $this->response->paginator($Goods,new GoodsTransformer());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category=category::find($request->category_id);
        if (!$category) return $this->response->errorBadRequest('分类不存在');
        if ($category->status == 0) return $this->response->errorBadRequest('分类被禁用');
        
        //追加user_id
        $user_id = auth('api')->id();
        $request->offsetSet('user_id',$user_id);

        //添加商品到数据库
        Good::create($request->all());
        $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        return $this->response->item($good,new GoodsTransformer());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodsRequest $request,Good $good )
    {
         //对分类进行一下检查，只能使用三级分类，并且分类不能被禁用
         $category= Category::find($request->category_id);
         if (!$category) return $this->response->errorBadRequest('分类不存在');
         if ($category->status == 0) return $this->response->errorBadRequest('分类被禁用');
          //添加商品到数据库
       $good->update($request->all());
        return $this->response->noContent();
    }

     /**
     * 是否上架
     */
    public function isOn(Good $good)
    {
        $good->is_on = $good->is_on == 0 ? 1 : 0;
        $good->save();
        return $this->response->noContent();
    }

     /**
     * 是否推荐
     */
    public function isRecommend(Good $good)
    {
        $good->is_recommend = $good->is_recommend == 0 ? 1 : 0;
        $good->save();
        return $this->response->noContent();
    }
}
