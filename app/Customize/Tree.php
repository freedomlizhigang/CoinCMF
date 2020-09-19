<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-15 19:49:26
 * @Description: 无限级别分类表更新、树形菜单生成
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-02-26 21:58:55
 * @FilePath: /hyperf/app/Customize/Tree.php
 */

declare(strict_types=1);

namespace App\Customize;

class Tree {
	// 权限菜单转成树形菜单数组
	public function menuToTree($data, $pid)
	{
		$tree = [];
		if ($data->count() > 0) {
			foreach ($data as $v) {
				if ($v->parentid == $pid) {
					$v = ['menu_id' => $v->id, 'title' => $v->name, 'expand' => true];
					$v['children'] = $this->menuToTree($data, $v['menu_id']);
					$tree[] = $v;
				}
			}
		}
		return $tree;
	}
	// 角色权限选择转成树形菜单数组
	public function rolePrivToTree($priv, $data, $pid)
	{
		$tree = [];
		if ($data->count() > 0) {
			foreach ($data as $v) {
				if ($v->parentid == $pid) {
					$v = ['menu_id' => $v->id, 'title' => $v->name, 'expand' => false];
					// 所有子菜单都选中的时候，此菜单选中checked，部分选中时selected
					$child_count = $data->where('parentid', $v['menu_id'])->count();
					// 没有子菜单的时候，判断他本身
					if ($child_count == 0) {
						$v['checked'] = $priv->where('menu_id', $v['menu_id'])->count() > 0 ? true : false;
					}
					$v['children'] = $this->rolePrivToTree($priv, $data, $v['menu_id']);
					$tree[] = $v;
				}
			}
		}
		return $tree;
	}
	// 转成树形数组
	public function typeToTree($data, $pid)
	{
		$tree = [];
		if ($data->count() > 0) {
			foreach ($data as $v) {
				if ($v->parentid == $pid) {
					$v = $v->toArray();
					$v['childs'] = $this->typeToTree($data, $v['id']);
					$tree[] = $v;
				}
			}
		}
		return $tree;
	}
	// 转成树形表格用的数据，这个有点坑，必须定义一个循环外的变量来返回，循环内变量会被覆盖导致数据出错
	private $res = [];
	public function toTableTree($data, $pid = 0)
	{
		if (is_null($data) || $data == '') {
			return $this->res;
		}
		foreach ($data as $v) {
			// 计算level
			$left = 0;
			$level = count(explode(',', $v['arrparentid']));
			$str = '';
			if ($level > 1) {
				$str .= '|—';
				$left = 10 * $level;
			}
			$res = $v;
			$res['name'] = $str . $v['name'];
			$res['left'] = $left;
			$this->res[] = $res;
			if ($v['childs'] != '') {
				$this->toTableTree($v['childs'], $pid);
			}
		}
		return $this->res;
	}
	// 通用转成树形菜单数组
	public function toTree($data, $pid) {
		$tree = [];
		if ($data->count() > 0) {
			foreach ($data as $v) {
				if ($v->parentid == $pid) {
					$v = $v->toArray();
					$v['parentid'] = $this->toTree($data, $v['id']);
					$tree[] = $v;
				}
			}
		}
		return $tree;
	}
	// 树形菜单 html
	public function toTreeSelect($tree, $pid = 0) {
		$html = '';
		if (is_null($tree) || $tree == '') {
			return $html;
		}
		foreach ($tree as $v) {
			// 计算level
			$level = count(explode(',', $v['arrparentid']));
			$str = '';
			if ($level > 1) {
				for ($i = 2; $i < $level; $i++) {
					$str .= '| ';
				}
				$str .= ' |—';
			}
			// level < 4 是为了不添加更多的层级关系，其它地方不用判断，只是后台菜单不用那么多级
			if ($pid == $v['id']) {
				if ($level == 1) {
					$html .= "<option value='" . $v['id'] . "' selected='selected' style='font-weight:bold;'>" . $str . $v['name'] . "</option>";
				} else {
					$html .= "<option value='" . $v['id'] . "' selected='selected'>" . $str . $v['name'] . "</option>";
				}
			} else {
				if ($level == 1) {
					$html .= "<option value='" . $v['id'] . "' style='font-weight:bold;'>" . $str . $v['name'] . "</option>";
				} else {
					$html .= "<option value='" . $v['id'] . "'>" . $str . $v['name'] . "</option>";
				}
			}
			if ($v['parentid'] != '') {
				$html .= $this->toTreeSelect($v['parentid'], $pid);
			}
		}
		return $html;
	}
	/**
	 * 更新类别缓存用的操作
	 * @param  [type] $model [模型]
	 * @return [type] $cacheName [缓存名称]
	 */
	public function updateTable($model) {
		$types = [];
		$types = $model->get()->toArray();
		// 将数组索引转化为typeid，phpcms v9的select方法支持定义数组索引，这个坑花了两小时
		$types = $this->orderTypes($types, 'id');
		$this->types = $types;
		if (is_array($this->types)) {
			foreach ($this->types as $id => $type) {
				// 取得所有父栏目
				$arrparentid = $this->arrParentid($id);
				$arrchildid = $this->arrChildid($id);
				$child = is_numeric($arrchildid) ? 0 : 1;
				// 如果父栏目数组、子栏目数组，及是否含有子栏目不与原来相同，更新，字符串比较使用strcasecmp()方法，直接比较字符串会出问题,
				if (strcasecmp((string) $types[$id]['arrparentid'],(string) $arrparentid) != 0 || strcasecmp((string) $types[$id]['arrchildid'], (string) $arrchildid) != 0 || $types[$id]['child'] != $child) {
					$model->where('id', $id)->update(['arrparentid' => $arrparentid, 'arrchildid' => $arrchildid, 'child' => $child]);
				}
			}
		}
		//删除在非正常显示的栏目
		foreach ($this->types as $type) {
			if ($type['parentid'] != 0 && !isset($this->types[$type['parentid']])) {
				$model->destroy($type['id']);
			}
		}
	}
	// 循环用的 types
	private $types = [];
	/**
	 * 以索引重排结果数组
	 * @param array $types
	 * $id 主键
	 */
	private function orderTypes($types = array(), $id = '') {
		$temparr = array();
		if (is_array($types) && !empty($types)) {
			foreach ($types as $c) {
				// 以主键做为数组索引
				$temparr[$c[$id]] = $c;
			}
		}
		return $temparr;
	}
	/**
	 *
	 * 获取父栏目ID列表
	 * @param integer $id              栏目ID
	 * @param array $arrparentid          父目录ID
	 * @param integer $n                  查找的层次
	 */
	private function arrParentid($id, $arrparentid = '') {
		if (!is_array($this->types) || !isset($this->types[$id])) {
			return false;
		}

		$parentid = $this->types[$id]['parentid'];
		$arrparentid = $arrparentid ? $parentid . ',' . $arrparentid : $parentid;
		// 父ID不为0时
		if ($parentid) {
			$arrparentid = $this->arrParentid($parentid, $arrparentid);
		} else {
			// 如果父ID为0
			$this->types[$id]['arrparentid'] = $arrparentid;
		}
		$parentid = $this->types[$id]['parentid'];
		return $arrparentid;
	}
	/**
	 *
	 * 获取子栏目ID列表
	 * @param $id 栏目ID
	 */
	private function arrChildid($id) {
		$arrchildid = $id;
		if (is_array($this->types)) {
			foreach ($this->types as $k => $cat) {
				// $k != $id 不是自身
				// $cat['parentid'] 父栏目存在且不是顶级栏目
				// $cat['parentid'] == $id 父栏目ID是当前要获取子栏目的栏目id，即此次循环的栏目正是当前栏目子栏目
				if ($cat['parentid'] && $k != $id && $cat['parentid'] == $id) {
					$arrchildid .= ',' . $this->arrChildid($k);
				}
			}
		}
		return $arrchildid;
	}
}