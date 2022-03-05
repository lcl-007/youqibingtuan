<?php
//微信授权

use App\Http\Controllers\BaseController;

class wechat extends BaseController
{
    public function wxsq()
{
    //前端传输两个值
    $param = request()->param();
    $code = isset($param['code']) ? $param['code'] : "";
    $user = isset($param['userInfo']) ? $param['userInfo'] : "";  //用户头像，昵称等信息
    //判断两个值是否存在
    if ($code == "" || $user == "") {
        return json(['code' => 0, 'msg' => "参数不能为空", 'data' => []]);
    }
    //小程序的信息
    $appID = "wx71593ecbb80bb730"; // APPID
    $appSecret = "22fb78d287e2ff8820291dc2181a6318"; // 密钥
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appID . "&secret=" . $appSecret . "&js_code=" . $code . "&grant_type=authorization_code"; //获取地址
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    //执行命令
    $response = curl_exec($curl);
    $errorno = curl_errno($curl);
    $error = curl_error($curl);
    $scode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //关闭URL请求
    curl_close($curl);
    //请求是否成功
    if ($scode != 200) {
        return json(['code' => 0, 'msg' => "请求失败", 'data' => []]);
    }
    //初始化生成数组
    $request = json_decode($response, true);
    $openID = $request["openid"]; //获取openid
    $sessionKey = $request["session_key"];
    //数据生成json
    $userInfo = json_decode($user, true); //生成json 形式
    $images = $userInfo['avatarUrl']; //头像
    $nick = $userInfo['nickName']; //昵称
    //查看会员是否存在
    try {
        $Selectuser = UserModel::where('openid', $openID)->find();
    } catch (Exception $e) {
        return json(['code' => 0, 'msg' => '数据异常，初始化失败！', 'data' => '']);
    }
    if (!empty($Selectuser)) {
        $array = ['code' => 1, 'msg' => "查看会员id", 'data' => $Selectuser['id']];
    } else {
        //插入数据库
        $no = rand(1000, 9999);
        $reg_time = date('Y-m-d H:i:s');
        $data = ['name' => $nick, 'openid' => $openID, 'head' => $images, 'reg_time' => $reg_time];
        try {
            $insertuserid = UserModel::create($data);
            if ($insertuserid['id'] > 0) {
                //修改会员编号：会员编号（随机四位数+（id））
                UserModel::where('id', $insertuserid['id'])->update(['nums' => $no . $insertuserid['id']]);
            }
        } catch (Exception $e) {
            return json(['code' => 0, 'msg' => '保存数据失败！', 'data' => '']);
        }
        if (!empty($insertuserid)) {
            $array = ['code' => 1, 'msg' => "添加成功", 'data' => $insertuserid['id']];
        } else {
            $array = ['code' => 0, 'msg' => "添加失败", 'data' => []];
        }
    }
    return json($array);
}
}

