<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use EasyWeChat\Factory;

class WxloginController extends BaseController
{
    public function userAuth(Request $request)
    {

		//下面的参数都是前端传过来的
        $code = $request->code;//前端传过来的code
        $userinfo =$request->userInfo;//前端穿过来的个人信息
        //获取小程序easyWeChat实例
        $app = app('wechat.mini_program');
        //得到session_key和openid
        $data = $app->auth->session($code);
        //将传过来的json转换成数组
        $wechat = json_decode($userinfo,true);
        //验证是否过期或错误
        if (isset($data['errcode'])) {
            return ['code' => 404, 'massage' => 'code已过期或不正确'];
        }
        //将用户信息保存到数据库
        $user = User::UpdateOrCreate(['openid'=>$data['openid']],[
            'openid'=>$data['openid'],
            'session'=>$data['session_key'],
            'avatar'=>$wechat['avatarUrl'],
            'nickname'=>$wechat['nickName'],
            'name'=>$wechat['nickName'],
            'password'=>bcrypt($data['openid']),
        ]);
     
    }
}
