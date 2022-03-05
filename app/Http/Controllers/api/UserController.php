<?php

namespace App\Http\Controllers\api;
use App\Transformers\UserTransformer;
use App\Http\Controllers\BaseController;
use App\Models\Good;
use App\Models\User;
use Yansongda\LaravelPay\Facades\Pay;
use Illuminate\Http\Request;
use Yansongda\Pay\Provider\Wechat;

class UserController extends BaseController
{

    public function admin()
    {
        return view('admin');
    }
    /**
     * 用户个人信息
     */
    public function userInfo()
    {
        return $this->response->item(auth('api')->user(),new UserTransformer());
    }

    /**
     * 更新用户信息
     */
    public function updateUserInfo(Request $request)
    {
        $request->validate([
            'name'=>'required|max:16',
        ]);
        $user = auth('api')->user();
        $user->name = $request->input('name');
        $user->save();
        return $this->response->noContent();
    }

    /**
     * 更新用户头像
     */
    public function avatarUpdate(Request $request)
    {
        $request->validate([
            'avatar'=>'required',
        ]);
        $user = auth('api')->user();
        $user->avatar = $request->input('avatar');
        $user->save();
        return $this->response->noContent();
    }

    //积分商城
    public function integral_shop()
    {
        $user_integral = auth('api')->user()->integral;

        $goods = Good::select('title','stock','integral')->where('is_on',1)->get();
        return [
            'user_integral'=>$user_integral,
             'goods'=>$goods
        ];
      
    }

    //钱包余额
    public function balance()
    {
        $uid = auth('api')->id();
        $udata = User::where('id',$uid)->get('allmoney');
        return $udata;
    }

    //微信充值
    public function wcinsert(Request $request)
    {
        $input = $request->input('money');

        // $orders = [
        //     'out_trade_no' => time(),
        //     'body' => '充值金额',
        //     'total_fee'=>$input ,
        //     'openid' => auth('api')->user()->openid, 
        // ];
        // $payok=Pay::wechat()->mini($orders);
        if ($input) {
            $um = auth('api')->id();
            User::where('id',$um)->increment('allmoney',$input);
            User::where('id',$um)->increment('integral',$input);
            return '您已成功充值'.$input.'元';
        
        }
        return '充值失败';
    }

    //充值明细

}
