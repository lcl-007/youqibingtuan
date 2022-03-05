<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
	protected $table = 'orders';


	protected $dates = [
		'pay_time'
	];

	protected $fillable = [
		'user_id',
		'order_no',
		'amount',
		'status',
		'pay_time',
		'is_checked'
	];
	 /**
     * 所属用户
     */
    public function user( )
    {
        //belongsto里面的参数（关联模型，外键，主键，关系）
        return $this->belongsTo(User::class,'user_id','id');
    }
     /**
     * 订单拥有的细节
     */
    public function orderDetails( )
    {
        return $this->hasMany(OrderDetails::class,'order_id','id');
    }
/**
 * 订单远程一对多 关联的商品
 */
    public function goods()
    {
        return $this->hasManyThrough(
            Good::class, //最终关联的模型
            OrderDetails::class,//中间模型
            'order_id', // 中间模型和本模型关联的外键
            'id', // 最终关联模型的外键
            'id', // 本模型和中间模型关联的键
            'goods_id' // 中间表和最终模型关联的主键
        );
    }

}
