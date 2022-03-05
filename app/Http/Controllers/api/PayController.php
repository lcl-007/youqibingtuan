<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;
class PayController extends BaseController
{
    public function WeChatPay(Request $request ,Order $order)
    {
       
        //判断订单状态是否是1
        if ($order->status !=1) {
            return $this->response->errorBadRequest('订单状态异常');
        }
            $orders = [
                'out_trade_no' => time(),
                'body' => 'subject-测试',
                'total_fee'=> '1',
                'openid' => '',
            ];
            Order::where('user_id',auth('api')->id)
            ->update(['pay_time'],[now()]);
            return Pay::wechat()->mini($orders);
    } 
//通知
    public function notify()
    {
        $pay = Pay::wechat($this->config);
        try {
            $data = $pay->verify();
             //判断支付状态
             if ($data->trade_status =='TRADE_SUCCESS'||$data->trade_status =='TRADE_FINISHED') {
                //查询订单
                $order = Order::where('order_no',$data->out_trade_no)->first();
                //更新订单
                $order->update([
                    'status'=>2,
                    'pay_time'=>$data->gmt_payment,
                    'trade_no'=>$data->trade_no
                ]);
            }
            Log::debug("wechatpay notify",$data->all());
          
        } catch (\Throwable $th) {
            $pay->success();
        }
    }
    //查看支付状态
    public function payStatus(Order $order)
    {
        return $order->status;
    }

     //退款
     public function refund(Order $order)
     {
             //微信退款 
//      $gateway = ::create('WechatPay');
//      $gateway->setAppId('商户平台APPID');
//      $gateway->setMchId('商户号');
//      $gateway->setApiKey('商户apikey（商户平台自行设置）');
//      $gateway->setCertPath(app_path('apiclient_cert.pem')); // 微信退款需要的证书
//      $gateway->setKeyPath(app_path('apiclient_key.pem')); // 微信退款需要的证书
//      $response = $gateway->refund([
//          'out_trade_no' => '订单号',
//          'transaction_id' => '微信支付单号', //The wechat trade no 
//          'out_refund_no' => date('YmdHis') . mt_rand(1000, 9999),
//          'total_fee' => '支付金额', //=0.01 
//          'refund_fee' => '退款金额', //=0.01
//      ])->send();
 
//      if ($response->isSuccessful() === true){
//          // 可对订单做相关处理    
//          return response()->json(['code'=>200,'msg'=>'退款成功']);
//      }else{
//          return response()->json(['code'=>404,'msg'=>'已退款或者账户余额不足']);
 
//          }
 }
}
