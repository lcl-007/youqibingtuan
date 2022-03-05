<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Coupon;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;


class UserController extends BaseController
{

    //用户列表
    public function index(Request $request)
    {
        $name = $request->input('name');
        $phone = $request->input('phone');
        //搜索模糊查询
        $users = User::when($name,function ($query) use($name){
                $query->where('name','like',"%$name%");
        })
        ->when($phone,function($query) use($phone){
                $query->where('phone',$phone); 
        })
        ->paginate(2);
        return $this->response->paginator($users,new UserTransformer());
        
    }
    // 用户详情
    public function show(User $user)
    {
      return $this->response->item($user,new UserTransformer());
    }

     /**
     * 禁用和启用用户
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        $user->save();
        return $this->response->noContent();
    }

    //创建优惠券
    public function create_coupon(Request $request)
    {
        Coupon::create($request->all());
            return $this->response->created();
        
    }

     /**
     * 是否启用优惠券
     */
    public function isOn(Coupon $coupon)
    {
        $coupon->ison = $coupon->ison == 0 ? 1 : 0;
        $coupon->save();
        return $this->response->noContent();
    }
}
