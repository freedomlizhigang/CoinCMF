<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-29 21:40:40
 * @Description: 签名验证
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-03-12 18:04:45
 * @FilePath: /ledger/app/Customize/Sign.php
 */

declare (strict_types = 1);

namespace App\Customize;

class Sign {
	public static function create($request) {
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
	public static function checkSign($all) {
		try {
			$sign = $all['sign'];
			// 检查请求时间
			if (time() - $all['timestamp'] >= 30) {
				return ['code' => 404, 'msg' => '请求超时'];
			}
			unset($all['sign']);
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
}
