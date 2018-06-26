<?php
/*
 * 此文件用于验证短信服务API接口，供开发时参考
 * 执行验证前请确保文件为utf-8编码，并替换相应参数为您自己的信息，并取消相关调用的注释
 * 建议验证前先执行Test.php验证PHP环境
 *
 * 2017/11/30
 */

namespace App\Customize\Dysms;

use App\Customize\Dysms\SignatureHelper;
/**
*
*/
class SendBatchSms
{
    /**
     * 发送短信
     */
    public static function sendSms($phone = [],$sign = [],$tmp = []) {
        try {
            $params = array ();
            // *** 需用户填写部分 ***
            // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
            $accessKeyId = "LTAIB6tuDIvju1VN";
            $accessKeySecret = "PoGCxUFiJthdV5uyXH6C7b1HPM6oEe";
            // fixme 必填: 待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
            $params["PhoneNumberJson"] = $phone;
            // fixme 必填: 短信签名，支持不同的号码发送不同的短信签名，每个签名都应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
            $params["SignNameJson"] = $sign;
            // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
            $params["TemplateCode"] = "SMS_133260555";
            // fixme 必填: 模板中的变量替换JSON串,如模板内容为"亲爱的${name},您的验证码为${code}"时,此处的值为
            // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
            /*
            array(
                array(
                    "name" => "Tom",
                    "code" => "123",
                ),
                array(
                    "name" => "Jack",
                    "code" => "456",
                ),
            )
             */
            $params["TemplateParamJson"] = $tmp;
            // fixme 可选: 设置发送短信流水号
            // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
            $params["TemplateParamJson"]  = json_encode($params["TemplateParamJson"], JSON_UNESCAPED_UNICODE);
            $params["SignNameJson"] = json_encode($params["SignNameJson"], JSON_UNESCAPED_UNICODE);
            $params["PhoneNumberJson"] = json_encode($params["PhoneNumberJson"], JSON_UNESCAPED_UNICODE);

            // if(!empty($params["SmsUpExtendCodeJson"] && is_array($params["SmsUpExtendCodeJson"]))) {
            //     $params["SmsUpExtendCodeJson"] = json_encode($params["SmsUpExtendCodeJson"], JSON_UNESCAPED_UNICODE);
            // }
            // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
            $helper = new SignatureHelper();
            // 此处可能会抛出异常，注意catch
            $content = $helper->request($accessKeyId,$accessKeySecret,"dysmsapi.aliyuncs.com",array_merge($params, array("RegionId" => "cn-hangzhou","Action" => "SendBatchSms","Version" => "2017-05-25")));
            return $content;
        } catch (\Exception $e) {
            // dd($e);
            return false;
        }
    }
}
