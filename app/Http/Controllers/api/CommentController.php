<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use App\Models\comment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * 商品评论
     */
    public function store(Request $request,Order $order)
    {
        $request->validate([
            'goods_id'=>'required',
            'content'=>'required',
        ],['goods_id.required'=>'商品id不能为空',
        'content.required'=>'评论内容不能为空'
    ]);
        //只有确认收货才可以评论
        if ($order->status !=4) {
          return $this->response->errorBadRequest('还没收货呢,咋能评论呢');
        }
        //要评论的商品必须是这个订单里面的
        if (!in_array($request->input('goods_id'),$order->orderDetails()->pluck('goods_id')->toArray())) {
            return $this->response->errorBadRequest('此订单不包含该商品');
        }

        //已经评论过的，不能再评论
        $checkComment = comment::where('user_id',auth('api')->id())
        ->where('order_id',$order->id)
        ->where('goods_id',$request->input('goods_id'))
        ->count();

        if ($checkComment>0) {
            return $this->response->errorBadRequest('此商品已经评论过了');

        }
        //生成评论数据
        $request->offsetSet('user_id',auth('api')->id());
        $request->offsetSet('order_id',$order->id);
        Comment::create($request->all());
        return $this->response->created();
    }

    public function mycomment()
    {
        $commentData=comment::where('user_id',auth('api')->id())
        ->with('user:id,name,avatar')
        ->get();
        return $commentData;
    }
}
