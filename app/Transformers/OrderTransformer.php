<?php


namespace App\Transformers;

use App\Models\Good;
use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user','orderdetails','goods'];

public function transform(Order $order)
{
    

    return [
      'id' =>$order->id,
      'order_no'=>$order->order_no,
      'user_id'=>$order->user_id,
      'amount'=>$order->amount,
      'status'=>$order->status,
      'pay_time'=>$order->pay_time,
      'created_at'=>$order->created_at,
      'updated_at'=>$order->updated_at,
    ];
}
/**
 * 额外的用户数据
 */
public function includeUser(Order $order)
{
    return $this->item($order->user,new UserTransformer());
}
/**
 * 额外订单细节数据
 */
public function includeOrderDetails(Order $order)
{
    return $this->collection($order->orderDetails,new OrderDetailsTransformer());
}
/**
 * 额外的商品数据
 */
public function includeGoods(Order $order)
{
    return $this->collection($order->goods,new GoodsTransformer());
}
}
