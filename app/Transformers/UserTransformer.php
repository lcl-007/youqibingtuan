<?php


namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract 
{

  public function transform(User $user)
  {
    return [
      'id' =>$user->id,
      'name'=>$user->name,
      'avatar'=>$user->avatar,
      'phone'=>$user->phone,
      'integral'=>$user->integral,
      'coupon'=>$user->coupon,
      'allmoney'=>$user->allmoney,
      'is_locked'=>$user->is_locked,
      'created_at'=>$user->created_at,
      'updated_at'=>$user->updated_at,
    ];
  }
 
}

