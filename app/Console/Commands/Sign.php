<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sign extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sign';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '测试签名';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		// 请求时间
		$timestamp = '1577433136808';
		$sign = '12E5AA441FA13B18A0E7366CC6D9E9AF';
		// 签名生成方式
		$all = ['name' => 111, 'password' => 111111, 'sign' => $sign, 'timestamp' => $timestamp];
		unset($all['sign']);
		// 参数排序
		ksort($all);
		// 参数组合
		// $str = $appsecrect;
		$str = '';
		foreach ($all as $k => $v) {
			$str .= $k . $v;
		}
		// $str .= $appsecrect;
		$str = md5($str);
		// 转16位
		$hex = '';
		for ($i = 0; $i < strlen($str); $i++) {
			$hex .= dechex(ord($str[$i]));
		}
		// 转大写
		$newsign = strtoupper($str);
		if ($sign == $newsign) {
			dd(true);
		}
		dd($newsign);
	}
}
