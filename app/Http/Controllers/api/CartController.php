<?php

namespace App\Http\Controllers\api;
use App\Models\Cart;
use App\Models\Good;
use App\Http\Controllers\BaseController;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;

class CartController extends BaseController
{
     /**
     * Display a listing of the 购物车商品列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::where('user_id',auth('api')->id())
        ->get();
        return $this->response->collection($carts,new CartTransformer());
    }

    /**
     *加入购物车
     */
    public function store(Request $request)
    {
        $request->validate([
            'goods_id'=>'required|exists:goods,id',
            //数量不能超过商品库存
            'num'=>[
                function($attribute,$value,$fill)use ($request){
                    $goods = Good::find($request->goods_id);
                    if ($value > $goods->stock) {
                      $fill('数量不能超过库存');
                    }
                }
            ]
        ],[
            'goods_id.required'=>'商品ID不能为空',
            'goods_id.exists'=>'商品不存在'
        ]);

        //查询购物车数据是否存在
        $cart=Cart::where('user_id',auth('api')->id())
        ->where('goods_id',$request->input('goods_id'))
        ->first();

        if (!empty($cart)) {
            $cart->num = $request->input('num',1);
            $cart->save();
            return $this->response->noContent();
        }

        Cart::create([
            'user_id'=>auth('api')->id(),
            'goods_id'=>$request->input('goods_id'),
            'num'=>$request->input('num',1),
            'appointment'=>$request->appointment, 
        ]);
        return $this->response->created();
    }



    /**
     *更新购物车商品
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'num'=>['required',
            'gte:1',
            function($attribute,$value,$fail)use($cart){
                if ($value>$cart->goods->stock) {
                    $fail('数量不能超过最大库存');
                } } ]
            ],[
                'num.required'=>'数量 不能为空',
                'num.gte'=>'数量 最少是1'
            ]);
            $cart->num = $request->input('num');
            $cart->save();
            return $this->response->noContent();
    }

    /**
     *移除购物车
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return $this->response->noContent();

    }
}
