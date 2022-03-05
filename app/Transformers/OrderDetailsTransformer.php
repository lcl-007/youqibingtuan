<?php


namespace App\Transformers;

use App\Models\OrderDetails;
use League\Fractal\TransformerAbstract;

class OrderDetailsTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['goods'];
public function transform(OrderDetails $orderDetails)
{
    return [
      'id' =>$orderDetails->id,
      'order_id'=>$orderDetails->order_id,
      'orders_id'=>$orderDetails->goods_id,
      'price'=>$orderDetails->price,
      'num'=>$orderDetails->num,
      'integral'=>$orderDetails->integral,
      'created_at'=>$orderDetails->created_at,
      'updated_at'=>$orderDetails->updated_at,
    ];
}

/**
 * 额外商品
 */
public function includeGoods(OrderDetails $orderDetails)
{
    //调用OrderDetails模型里的goods方法，返回GoodsTransformer对象字段的item。
    return $this->item($orderDetails->goods,new GoodsTransformer());
}
}
