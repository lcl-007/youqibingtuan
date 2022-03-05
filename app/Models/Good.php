<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Good extends Model
{
	protected $table = 'goods';
	protected $fillable = [
		'title',
		'user_id',
		'category_id',
		'description',
		'price',
		'sales',
		'stock',
		'cover',
		'is_on',
		'is_recommend',
		'details',
		'time',
		'appointment',
		'people_num',
        'integral'
	];
	protected $casts = [
        'pics'=>'array',
    ];
    /**
     * 使用修改器追加额外的属性
     */
    //protected $appends = ['cover_url'];
    /*
    * cover oss url
    */
    // public function getCoverUrlAttribute()
    // {
    //     return oss_url($this->cover);
    // }
    // // pics oss url
    // public function getPicsUrlAttribute()
    // {
    //     //使用集合处理每一项的元素
    //   return collect($this->pics)->map(function($item){
    //        return oss_url($item);
    //    });
    // }
    /**
     * 商品所属的分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    /**
     * 商品所属的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 商品所属的评论
     */
    public function comments()
    {
        return $this->hasMany(Comment::class,'goods_id','id');
    }
}
