<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'pid' => 'int',
		'status' => 'int',
		'level' => 'int'
	];

	protected $fillable = [
		'name',
		'pid',
		'status',
		'group',
		'level'
	];
	 //分类的子类
	 public function children()
	 {
		 return $this->hasMany(Category::class,'pid','id');
	 }
}
