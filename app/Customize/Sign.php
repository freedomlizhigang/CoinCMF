<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-29 21:40:40
 * @Description: 签名验证
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-01-19 14:25:10
 * @FilePath: /CoinCMF/app/Customize/Sign.php
 */

declare(strict_types=1);

namespace App\Customize;

use App\Customize\MyCrypt;

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
				$str .= $k . $v;
			}
			$str .= $appsecrect;
			$str = md5($str);
			// 转16位
			$hex = '';
			for ($i = 0; $i < strlen($str); $i++) {
				$hex .= dechex(ord($str[$i]));
			}
			// 转大写
			$newsign = strtoupper($str);
			return $sign;
		} catch (\Throwable $e) {
			return false;
		}
	}
	// 验证api签名
	public static function checkSign($all)
	{
		try {
			$sign = $all['sign'];
			// 检查请求时间
			if (time() - $all['timestamp'] >= 30) {
				return ['code' => 404, 'msg' => '请求超时'];
			}
			$rsa = MyCrypt::privDecrypt($all['rsa']);
			unset($all['sign']);
			unset($all['rsa']);
			// 参数排序
			ksort($all);
			// var_dump($all);
			// 参数组合
			$str = '';
			foreach ($all as $k => $v) {
				if (is_array($v)) {
					$str .= $k . implode(',', $v);
				} else {
					$str .= $k . $v;
				}
			}
			// var_dump($str);
			$str = md5($str);
			// 转16位
			$hex = '';
			for ($i = 0; $i < strlen($str); $i++) {
				$hex .= dechex(ord($str[$i]));
			}
			// 转大写
			$newsign = strtoupper($str);
			if ($sign == $newsign) {
				return ['code' => 200];
			} else {
				return ['code' => 404, 'msg' => '签名失败'];
			}
		} catch (\Throwable $th) {
			return ['code' => 404, 'msg' => '验证签名失败'];
		}
	}
	// 解密
	public static function aes_decrypt($all)
	{
		try {
			$data = MyCrypt::ssl_api_decrypt($all['sign']);
			// 参数转数组
			parse_str($data, $req);
			// 检查请求时间
			if (time() - $req['timestamp'] >= 30) {
				return ['code' => 404, 'msg' => '请求超时'];
			}
			// 存在token且可以验证过
			if ($req['token'] != MyCrypt::privApiDecrypt($all['rsa'])) {
				return ['code' => 403, 'msg' => '加密验证失败'];
			}
			return ['code' => 200, 'data' => $req];
		} catch (\Throwable $th) {
			return ['code' => 404, 'msg' => '验证签名失败'];
		}
	}
}
