<?php

//common.php（这是一个公共类页面，会员登录成功后，会员页面的其它功能都继承着这个公共类）

//以下代码只做实例功能演示，省略其它……
//这里用到了控制器初始化，这是thinkphp主自定义的，其实和php中构造方法 __construct()其实是一样的，
namespace app\index;

use app\common\model\CitysModel;
use think\Controller;

class common extends Controller
{
    private $config = [
        'appid' => "wx71593ecbb80bb730",// APPID
        'mch_id' => "1610595459",//商户号
        'key' => "Aihuayangsheng888888888888888888", // 支付API密钥
        'appSecret' => "22fb78d287e2ff8820291dc2181a6318" // 密钥
    ];
    //查询我的购物车
    public function topay($out_trade_no, $total_fee, $openId, $notify_url)
    {
        $data = array
        (
            'appid' => $this->config['appid'],
            'mch_id' => $this->config['mch_id'],
            'nonce_str' => md5($out_trade_no . date("YmdHis", time())),
            'body' => 'productname',  //商品名称组合，这里自己定义
            'out_trade_no' => $out_trade_no,        //订单号
            'total_fee' => 1,//$total_fee,测试时1分
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            'notify_url' => $notify_url, // 这里是异步回调地址
            'trade_type' => 'JSAPI',
            'openid' => $openId,
            'attach' => 'tatch',
            'detail' => 'details',
        );
        // 签名
        ksort($data);
        $stringA = "";
        foreach ($data as $key => $val) {
            if (trim($val) == "") {
                continue;
            }
            $stringA .= $key . "=" . $val . "&";
        }
        $stringSignTemp = $stringA . "key=" . $this->config['key'];
        $signValue = strtoupper(md5($stringSignTemp));
        $data["sign"] = $signValue; // 签名
        // 构建xml
        $xml = '<xml>';
        foreach ($data as $key => $val) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
        $xml .= '</xml>';
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type: text/xml"]);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 因为你的是https
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        //执行命令
        $response = curl_exec($curl);
        $errorno = curl_errno($curl);
        $error = curl_error($curl);
        $scode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //关闭URL请求
        curl_close($curl);

        if ($scode != 200) {
            return json_encode(array("Result" => false, "Message" => "请求失败"));
        }
        libxml_disable_entity_loader(true);
        $xml_tmp = json_encode(simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA));
        $request = json_decode($xml_tmp, true);
        //halt($request);die();
        if ($request["return_code"] != 'SUCCESS') {   // 统一下单失败
            return json_encode(array("Result" => false, "Message" => $request["return_msg"]));
            exit;
        } else {
            $res = array
            (
                "appId" => $this->config['appid'],
                "timeStamp" => (string)time(),
                'nonceStr' => md5(time()),
                'package' => "prepay_id=" . $request["prepay_id"],
                'signType' => 'MD5',
            );
            ksort($res);
            $stringA = '';
            foreach ($res as $key => $val) {
                $stringA .= $key . "=" . $val . "&";
            }
            $stringSignTemp = $stringA . "key=" . $this->config['key'];
            $signValue = strtoupper(md5($stringSignTemp));
            $res["paySign"] = $signValue;
            // 客户每次请求 ，都必须将此信息反馈给付段进行校验。如果没有。则说明没有登陆。
            return array("Result" => true, "Message" => "", "Data" => $res, "ordernums" => $out_trade_no);
        }
    }
    /**
     * 用腾讯地图根据两地经纬度获取距离
     * @param $from_lat
     * @param $from_lng
     * @param $to_lat
     * @param $to_lng
     * @return array
     */
    function getDistance($from_lat, $from_lng, $to_lat, $to_lng)
    {
        $key = 'HO4BZ-MVZK6-URKSG-MCTDY-DGZES-MNBQB'; //腾讯地图开发自己申请
        $mode = 'walking'; //driving(驾车)、walking(步行)
        $from = $from_lat . ',' . $from_lng;//'34.378052,118.367718'; //例如：39.14122,117.14428
        $to = $from_lat . ',' . $from_lng . ';' . $to_lat . ',' . $to_lng;//'34.378052,118.367718;34.358653,118.326766'; //例如(格式：终点坐标;起点坐标)：39.10149,117.10199;39.14122,117.14428
        $url = 'https://apis.map.qq.com/ws/distance/v1/?mode=' . $mode . '&from=' . $from . '&to=' . $to . '&key=' . $key;
        $info = file_get_contents($url);
        $info = json_decode($info, true);
        return $info;
    }

    /**
     * 用腾讯地图搜素地址获得经纬度,解决小程序定位不准的问题
     * @param string $address
     * @return array
     */
    public function getAddress_new($address = '')
    {
        $key = 'HO4BZ-MVZK6-URKSG-MCTDY-DGZES-MNBQB'; //腾讯地图开发自己申请
        $header[] = 'Referer: http://lbs.qq.com/webservice_v1/guide-suggestion.html';
        $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36';
        $url = "http://apis.map.qq.com/ws/place/v1/suggestion/?&region=&key=" . $key . "&keyword=" . $address;

        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);

        $output = json_decode($output, true);
        return $output;
    }

    /**
     * 【根据详细地址获取经纬度】
     *  20170920
     *
     * @param $address
     * @return array
     */
    function getPoint($address)
    {
        $key = 'HO4BZ-MVZK6-URKSG-MCTDY-DGZES-MNBQB'; //腾讯地图开发自己申请
        $url = "http://apis.map.qq.com/jsapi?qt=geoc&addr=" . $address . "&key=" . $key . "&output=jsonp&pf=jsapi&ref=jsapi&cb=qq.maps._svcb3.geocoder0";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//转为字符串，而不是直接输出
        $wetContent = curl_exec($ch);
        $data = iconv("GB18030", "UTF-8//IGNORE", $wetContent);
        $match = '/"pointx":"([\s\S]*?)",\s*?"pointy":"([\s\S]*?)"/';
        if (preg_match($match, $data, $rst)) {
            $arr = [
                'lat' => $rst[2],
                'lng' => $rst[1],
            ];
        } else {
            $arr = [
                'lat' => '',
                'lng' => '',
            ];
        }
        curl_close($ch);
        return $arr;
    }

    //向上查询数据库获取地址
    function get_address($id, $arr = '')
    {
        $rows = CitysModel::where('id', $id)->find();
        $arr = $rows['name'] . $arr;
        if (!empty($rows['top_id'])) {
            return $this->get_address($rows['top_id'], $arr);
        }
        return $arr;
    }

    /**
     * 【数组根据指定元素值大小排序】
     *  20170920
     *
     * 指定根据哪个元素排序 @param $ks
     * 要排序的数组 @param $b
     * @return array
     */
    function get_sort($ks,$b)
    {
        $date = array_column($b, $ks);
        array_multisort($date,SORT_DESC,$b);
        //去重
        // 1. 循环出所有的行. ( $val 就是某个行)
        $tmp_array = array();
        $new_array = array();
        foreach($b as $k => $val){
            $hash = md5(json_encode($val));
            if (!in_array($hash, $tmp_array)) {
                // 2. 在 foreach 循环的主体中, 把每行数组对象得hash 都赋值到那个临时数组中.
                $tmp_array[] = $hash;
                $new_array[] = $val;
            }
        }
        return $new_array;

        //$a是排序数组，$b是要排序的数据集合，$result是最终结果
        $a = array();
        foreach ($b as $key => $val) {
            $a[] = (string)$val[$ks];//这里要注意$val['nums']不能为空，不然后面会出问题
        }
        //$a先排序
        rsort($a);
        $a = array_flip($a);
        $result = array();
        foreach ($b as $k => $v) {
            $temp1 = $v[$ks];
            $temp2 = $a[(string)$temp1];
            $result[$temp2] = $v;
        }
        //这里还要把$result进行排序，健的位置不对
        ksort($result);

        //去重
        // 1. 循环出所有的行. ( $val 就是某个行)
        $tmp_array = array();
        $new_array = array();
        foreach($result as $k => $val){

            $hash = md5(json_encode($val));
            if (in_array($hash, $tmp_array)) {
                echo('这个行已经有过了');
            }else{
                // 2. 在 foreach 循环的主体中, 把每行数组对象得hash 都赋值到那个临时数组中.
                $tmp_array[] = $hash;
                $new_array[] = $val;
            }
        }

        return $new_array;
    }
}