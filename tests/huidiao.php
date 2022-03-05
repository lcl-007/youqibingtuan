<?php 
//唤起支付
$openId = !empty($user['openid']) ? $user['openid'] : "";
            if (empty($openId)) {
                return json_encode(array("Result" => false, "Message" => "OpenId数据异常", "Data" => [], "ordernums" => ''));
            }
$osn = '订单编号'；
$total_fee = 100 * $total;    //产品总价
$notify_url = Request::domain() . '/index/index/notify_urls';
$rs = $this->topay($osn, $total_fee, $openId, $notify_url);






//支付回调
    public function notify_url()
    {
        $menberid = request()->param('oid');
        try {
            $order = OrdersModel::where('order_num', $menberid)->find();
            OrdersModel::where('id', $order['id'])->update(['pay' => 1,'stat'=>1]);
            $str = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
            echo $str;
            exit('回调成功');
        } catch (Exception $e) {
            $str = '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[ERROR]]></return_msg></xml>';
            echo $str;
            exit('回调失败');
        }
    }