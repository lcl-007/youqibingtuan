<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{
	protected $table = 'coupons';

	

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'goods_id',
		'user_id',
		'title',
		'price',
		'content',
		'ison',
		'time'
	];
}
