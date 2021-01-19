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
class SendSms
{
    /**
     * 发送短信
     */
    public static function sendSms($phone = '',$code = '123456',$tpl = 'SMS_137810257') {
        try {
            $params = array ();
            // *** 需用户填写部分 ***
            // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
            $accessKeyId = "";
            $accessKeySecret = "";
            // fixme 必填: 短信接收号码
            $params["PhoneNumbers"] = $phone;
            // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
            $params["SignName"] = "";
            // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
            $params["TemplateCode"] = $tpl;
            // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
            $params['TemplateParam'] = ["code"=>$code];
            // fixme 可选: 设置发送短信流水号
            $params['OutId'] = "12345";
            // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
            $params['SmsUpExtendCode'] = "1234567";
            // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
            if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                $params["TemplateParam"] = json_encode($params["TemplateParam"]);
            }
            // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
            $helper = new SignatureHelper();
            // 此处可能会抛出异常，注意catch
            $content = $helper->request($accessKeyId,$accessKeySecret,"dysmsapi.aliyuncs.com",array_merge($params, array("RegionId" => "cn-hangzhou","Action" => "SendSms", "Version" => "2017-05-25")));
            // fixme 选填: 启用https
            // ,true
            return $content;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
