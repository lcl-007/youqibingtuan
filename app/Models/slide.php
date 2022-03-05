<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Slide extends Model
{
	protected $table = 'slides';
    // protected $appends = ['img_url'];


	protected $fillable = [
		'title',
		'url',
		'img',
		'status',
		'seq'
	];
	//对应字段的修改器
    // public function getImgUrlAttribute()
    // {
    //     return oss_url($this->img);
    // }
}
