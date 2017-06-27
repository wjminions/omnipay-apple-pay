<?php
namespace Omnipay\ApplePay;

/**
 * Class Helper
 * @package Omnipay\ApplePay
 */
class Helper
{
    /**
     * 21000 App Store不能读取你提供的JSON对象
     * 21002 receipt-data域的数据有问题
     * 21003 receipt无法通过验证
     * 21004 提供的shared secret不匹配你账号中的shared secret
     * 21005 receipt服务器当前不可用
     * 21006 receipt合法，但是订阅已过期。服务器接收到这个状态码时，receipt数据仍然会解码并一起发送
     * 21007 receipt是Sandbox receipt，但却发送至生产系统的验证服务
     * 21008 receipt是生产receipt，但却发送至Sandbox环境的验证服务
     */
    public static function sendHttpRequest($receipt_data, $url)
    {
        //小票信息
        $POSTFIELDS = array("receipt-data" => $receipt_data);
        $POSTFIELDS = json_encode($POSTFIELDS);

        //简单的curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTFIELDS);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    public static function validateApplePay($receipt_data, $url)
    {

        // 验证参数
        if (strlen($receipt_data)<20){
            $result=array(
                'status'=>false,
                'message'=>'非法参数'
            );
            return $result;
        }
        // 请求验证
        $html = static::sendHttpRequest($receipt_data, $url);
        $data = json_decode($html,true);

        // 如果是沙盒数据 则验证沙盒模式
        if($data['status']=='21007'){
            // 请求验证
            $html = static::sendHttpRequest($receipt_data, 'https://sandbox.itunes.apple.com/verifyReceipt');
            $data = json_decode($html,true);
            $data['sandbox'] = '1';
        }

        if (isset($_GET['debug'])) {
            exit(json_encode($data));
        }

        // 判断是否购买成功
        if(intval($data['status'])===0){
            $result=array(
                'status'=>true,
                'message'=>'购买成功'
            );
        }else{
            $result=array(
                'status'=>false,
                'message'=>'购买失败 status:'.$data['status']
            );
        }
        return $result;
    }
}
