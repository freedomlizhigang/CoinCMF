<?php
/*
 * @package [App\Customize]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 签名验证方式
 *
 */
namespace App\Customize;

class Sign
{
    public static function create($request)
    {
        try {
            $appkey = config('sign.app_key');
            $appsecrect = config('sign.app_secrect');
            // 请求时间
            $timestamp = $request->timestamp;
            $sign = $request->sign;
            // 签名生成方式
            $all = $request->all();
            unset($all['sign']);
            // 参数排序
            ksort($all);
            // 参数组合
            $str = $appsecrect;
            foreach ($all as $k => $v) {
                $str .= $k.$v;
            }
            $str .= $appsecrect;
            $str = md5($str);
            // 转16位
            $hex='';
            for ($i=0; $i < strlen($str); $i++){
                $hex .= dechex(ord($str[$i]));
            }
            // 转大写
            $newsign = strtoupper($str);
            return $sign;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
