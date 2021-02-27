<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 公用的控制方法
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-02-27 11:08:40
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Common/CommonController.php
 */

namespace App\Http\Controllers\Console\Common;

use App\Models\Rbac\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Console\ResponseController;

class CommonController extends ResponseController {
	// 面包屑导航
	public function getBreadCrumbList(Request $req) {
		try {
			$label = $req->input('label');
			$self = Menu::where('label', $label)->select('id', 'arrparentid', 'name', 'url')->first();
			$breadcrumb = [];
			$title = '首页';
			$breadcrumb[] = ['name' => '首页', 'to' => '/console/index/index'];
			if (!is_null($self)) {
				$menuids = explode(',', $self->arrparentid);
				unset($menuids[0]);
				// 取所有父栏目出来
				$all = Menu::whereIn('id', $menuids)->select('id', 'parentid', 'url', 'name')->orderBy('id', 'asc')->get();
				foreach ($all as $v) {
					// if ($v->parentid == 0) {
					$breadcrumb[] = ['name' => $v->name, 'to' => ''];
					// } else {
					// 	$breadcrumb[] = ['name' => $v->name, 'to' => '/console/' . $v->url];
					// }
				}
				$breadcrumb[] = ['name' => $self->name, 'to' => ''];
				// $breadcrumb[] = ['name' => $self->name, 'to' => '/console/' . $self->url];
				// 标题
				$title = $self->name;
			}
			$res = ['title' => $title, 'breadcrumb' => $breadcrumb];
			return $this->resData(200, '获取成功！', $res);
		} catch (\Throwable $e) {
			return $this->resData(500, '获取失败，请稍后再试！');
		}
	}
}
