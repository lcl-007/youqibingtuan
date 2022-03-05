<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    //订单列表
    public function index(Request $request)
    {
        //查询条件
        $order_no = $request->input('order_no');
        $status = $request->input('status'); 

        $orders = Order::when($order_no,function($query)use($order_no){
            $query->where('order_no',$order_no);
        })
        ->when($status,function($query)use($status){
            $query->where('status',$status);
        })
        ->paginate();
        return $this->response->paginator($orders, new OrderTransformer());
    }

    //订单详情
    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransformer());

    }

    //发货
    public function post(Request $request,Order $order)
    {
        
        $order->status = 3;//发货状态 
        $order->save();
        return $this->response->noContent();
    }
}
