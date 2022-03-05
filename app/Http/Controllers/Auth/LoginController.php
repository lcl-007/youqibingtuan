<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;


class LoginController extends BaseController
{
    
    public function login(Request $request)
    {
        /**
         * 处理前端传过来的数据
         */
        $code = $request->code;//前端传过来的code
      
        $userinfo =$request->userInfo;//前端穿过来的个人信息

        //获取小程序easyWeChat实例
        $app = app('wechat.mini_program');

        //把接收过来的code存储到session里，得到session_key和openid
        $data = $app->auth->session($code);

        //将传过来的json转换成数组
        $wechat = json_decode($userinfo,true);

        //验证是否过期或错误
        if (isset($data['errcode'])) {
            return ['code' => 404, 'massage' => 'code已过期或不正确'];
        }
        //将用户信息保存到数据库
        $userd = User::UpdateOrCreate(['openid'=>$data['openid']],[
            'openid'=>$data['openid'],
            'session'=>$data['session_key'],
            'avatar'=>$wechat['avatarUrl'],
            'nickname'=>$wechat['nickName'],
            'name'=>$wechat['nickName'],
            'password'=>bcrypt($data['openid']),
        ]);

        /*
        *准备验证登录
        */
        $credentials = [
            'name'=>$userd['name'],
        'password'=>$userd['openid'],
          'openid'=>$userd['openid']];
      
        if (!$token = auth('api')->attempt($credentials) ){
            return $this->response->errorUnauthorized();
        }
      
        //检察用户状态
        $user = auth('api')->user();
       
        if ($user->is_locked == 1) {
            return $this->response->errorForbidden('被锁定了哦');
        }
        return $this->respondWithToken($token);
        
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     * 退出登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * 刷新token
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * 格式化返回
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 6000
        ]);
    }

}
