<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use App\Models\Good;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 订单列表
     */
    public function orderlist()
    {   
        //订单管理
        $user_data = DB::table('users')
        ->join('orders','users.id','=','orders.user_id')
        ->join('order_details','users.id','=','order_details.user_id')
        ->join('comments','users.id','=','comments.user_id')
        ->select('order_details.title',
        'order_details.age','order_details.tel','order_details.name','order_details.remarks',
        'order_details.appointment','comments.content',
        'order_details.cover','orders.order_no','orders.amount','order_details.num')
        ->get();
        return $user_data;
    }
    public function index(Request $request)
    {
        //订单检索
        $status = $request->query('status');
        $title = $request->query('title');

        $orders = Order::where('user_id',auth('api')->id())
        ->when($status,function($query)use($status){
            $query->where('status',$status);
        })
        ->when($title,function($query)use($title){
            $query->whereHas('goods',function($query)use($title){
                $query->where('title','like',"%{$title}%");
            });
        })
        ->paginate(3);
        return $this->response->paginator($orders,new OrderTransformer());
    }

    /**
     * 提交订单
     *
     */
    public function store(Request $request)
    {
       
        //处理插入的数据
        $user_id = auth('api')->id();
        $order_no = date('YmdHis').rand(10000,99999);
        $amount = 0;
        //购物车关联的goods表模型方法goods数据
        $carts = Cart::where('user_id',$user_id)
        ->where('is_checked',1)
        ->with(['goods:id,price,stock,title,cover','user:id,integral,allmoney'])
        // ->with('user:id,integral,allmoney')
        ->get();          
   
        //要插入订单详情的数据 
        $insertData = [];
        foreach ($carts as $key => $o) {

            //如果有商品库存不足,提示用户重新选择
            if ($o->goods->stock < $o->num) {
                return $this->response
                ->errorBadRequest($o->goods->title .'库存不足请重新选择商品');
            }
            // $u_input = $request->all(); 

            $insertData[]=[
                'user_id'=>$user_id,
                'cover'=>$o->goods->cover,
                'title'=>$o->goods->title,
                'goods_id'=>$o->goods_id,
                'price'=>$o->goods->price,
                'num'=>$o->num,
                'integral'=>$o->goods->price,
                'name'=>$request->name,
                'age'=>$request->age,
                'tel'=>$request->tel,
                'remarks'=>$request->remarks,
                'is_coupon'=>$request->is_coupon,
                'people_num'=>$request->people_num,
                'appointment'=>$o->appointment,
            ];
            $amount += $o->goods->price * $o->num;
        }
        try {
            DB::beginTransaction();
            //生成订单
            $order = Order::create([
                'user_id'=>$user_id,
                'order_no'=>$order_no,
                'amount'=>$amount
            ]);

        //生成订单详情
        $order->orderDetails()->createMany($insertData);

        //删除已经结算的订单数据
        Cart::where('user_id',$user_id)
        ->where('is_checked',1)
        ->delete();

       
        //减去商品对应的库存量
        foreach ($carts as  $cart) { 

            Good::where('id',$cart->goods_id)
            ->decrement('stock',$cart->num);
            
        }
        
        DB::commit();

        return $this->response->created();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
/**
 * 订单详情
 */
    public function show(Order $order)
    {
       
        return $this->response->item($order,new OrderTransformer());
    }

   

    /**
     * 确认收货
     */
    public function confirm(Order $order)
    {
        if ($order->status!=3) {
            return $this->response->errorBadRequest('订单状态异常');
        }
        try {
            DB::beginTransaction();
            $order->status = 4;
            $order->save();
            $orderDetails = $order->orderDetails;
        //增加订单下所有商品的销量
            foreach ($orderDetails as $v) {
                //更新商品销量
                Good::where('id',$v->goods_id)->increment('sales',$v->num);
            }

        DB::commit();
        } catch (\Exception $e) {
           DB::rollBack();
           throw $e;
        }

        return $this->response->noContent();
    }

   
}