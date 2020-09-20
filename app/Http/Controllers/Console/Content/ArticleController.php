<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 文章管理
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 20:10:01
 * @FilePath: /CoinCMF/app/Http/Controllers/Console/Content/ArticleController.php
 */

namespace App\Http\Controllers\Console\Content;

use App\Models\Common\Article;
use Illuminate\Http\Request;
use Validator;

class ArticleController extends ResponseController {
	/**
	 * 文章列表
	 * @return [type] [description]
	 */
	public function getList(Request $req) {
		try {
			$page = $req->input('page', 0);
			$size = $req->input('size', 10);
			$catid = $req->input('cateid');
			// 搜索关键字
			$key = $req->input('key', '');
			$starttime = $req->input('starttime');
			$endtime = $req->input('endtime');
			$list = Article::with(['cate' => function ($q) {
				$q->select('id', 'name');
			}])->where(function ($q) use ($catid) {
				if ($catid != '') {
					$q->where('cate_id', $catid);
				}
			})->where(function ($q) use ($key) {
				if ($key != '') {
					$q->where('title', 'like', '%' . $key . '%');
				}
			})->where(function ($q) use ($starttime) {
				if ($starttime != '') {
					$q->where('created_at', '>', date('Y-m-d H:i:s', $starttime / 1000));
				}
			})->where(function ($q) use ($endtime) {
				if ($endtime != '') {
					$q->where('created_at', '<', date('Y-m-d H:i:s', $endtime / 1000));
				}
			})->select('id', 'title', 'cate_id', 'hits', 'publish_at', 'sort')->where('del_flag', 0)
				->offset(($page - 1) * $size)->limit($size)->orderBy('id', 'desc')->get();
			$count = Article::with(['cate' => function ($q) {
				$q->select('id', 'name');
			}])->where(function ($q) use ($catid) {
				if ($catid != '') {
					$q->where('cate_id', $catid);
				}
			})->where(function ($q) use ($key) {
				if ($key != '') {
					$q->where('title', 'like', '%' . $key . '%');
				}
			})->where(function ($q) use ($starttime) {
				if ($starttime != '') {
					$q->where('created_at', '>', date('Y-m-d H:i:s', $starttime / 1000));
				}
			})->where(function ($q) use ($endtime) {
				if ($endtime != '') {
					$q->where('created_at', '<', date('Y-m-d H:i:s', $endtime / 1000));
				}
			})->select('id', 'title', 'cate_id', 'hits', 'publish_at', 'sort')->where('del_flag', 0)
				->orderBy('id', 'desc')->count();
			$reslist = [];
			foreach ($list as $v) {
				$reslist[] = ['id' => $v->id, 'sort' => $v->sort, 'title' => $v->title, 'hits' => $v->hits, 'catename' => $v->cate->name];
			}
			$res = ['list' => $reslist, 'total' => $count];
			return $this->resData(200, '获取数据成功...', $res);
		} catch (\Throwable $e) {
			return $this->resData(500, '获取数据失败，请稍后再试...');
		}
	}

	/**
	 * 添加文章
	 * Name: postAdd
	 * User: zy
	 * Date: 2018/12/23
	 * Time: 下午3:13
	 */
	public function postCreate(Request $request) {
		try {
			$validator = Validator::make($request->input(), [
				'cate_id' => 'required|max:255',
				'title' => 'required|max:255',
				'describe' => 'nullable|max:255',
				'content' => 'required',
			]);
			$attrs = array(
				'cate_id' => '栏目ID',
				'title' => '文章标题',
				'describe' => '描述',
				'content' => '文章内容',
			);
			$validator->setAttributeNames($attrs);
			if ($validator->fails()) {
				// 如果有错误，提示第一条
				return $this->resData(400, $validator->errors()->all()[0] . '...');
			}
			$data['cate_id'] = $request->input('cate_id');
			$data['title'] = $request->input('title');
			$data['thumb'] = $request->input('thumb', '');
			$data['video'] = $request->input('video', '');
			$data['describe'] = $request->input('describe');
			$data['content'] = $request->input('content');
			$data['sort'] = $request->input('sort', 0);
			Article::create($data);
			return $this->resData(200, '添加成功...');
		} catch (\Throwable $e) {
			return $this->resData(500, '添加文章失败，请重新操作...');
		}
	}
	//详情
	public function getDetail(Request $request) {
		try {
			$validator = Validator::make($request->input(), [
				'article_id' => 'required',
			]);
			$attrs = array(
				'article_id' => '文章ID',
			);
			$validator->setAttributeNames($attrs);
			if ($validator->fails()) {
				// 如果有错误，提示第一条
				return $this->resData(400, $validator->errors()->all()[0] . '...');
			}
			$id = $request->input('article_id');
			$info = Article::find($id);
			return $this->resData(200, '获取数据成功...', $info);
		} catch (\Throwable $e) {
			return $this->resData(500, '获取数据失败，请重新操作...');
		}
	}
	//编辑
	public function postEdit(Request $request) {
		try {
			$validator = Validator::make($request->input(), [
				'article_id' => 'required',
				'cate_id' => 'required|max:255',
				'title' => 'required|max:255',
				'describe' => 'nullable|max:255',
				'content' => 'required',
			]);
			$attrs = array(
				'article_id' => '文章ID',
				'cate_id' => '栏目ID',
				'title' => '文章标题',
				'describe' => '描述',
				'content' => '文章内容',
			);
			$validator->setAttributeNames($attrs);
			if ($validator->fails()) {
				// 如果有错误，提示第一条
				return $this->resData(400, $validator->errors()->all()[0] . '...');
			}
			$id = $request->input('article_id');
			$data['cate_id'] = $request->input('cate_id');
			$data['title'] = $request->input('title');
			$data['thumb'] = $request->input('thumb', '');
			$data['video'] = $request->input('video', '');
			$data['describe'] = $request->input('describe');
			$data['content'] = $request->input('content');
			$data['sort'] = $request->input('sort', 0);
			Article::where('id', $id)->update($data);
			return $this->resData(200, '编辑成功...');
		} catch (\Throwable $e) {
			return $this->resData(500, '编辑失败，请重新操作...');
		}
	}

	//删除
	public function postRemove(Request $request) {
		try {
			$validator = Validator::make($request->input(), [
				'article_id' => 'required',
			]);
			$attrs = array(
				'article_id' => '文章ID',
			);
			$validator->setAttributeNames($attrs);
			if ($validator->fails()) {
				// 如果有错误，提示第一条
				return $this->resData(400, $validator->errors()->all()[0] . '...');
			}
			$id = $request->input('article_id');
			Article::where('id', $id)->delete();
			return $this->resData(200, '删除成功...');
		} catch (\Throwable $e) {
			return $this->resData(500, '删除失败，请重新操作...');
		}
	}

	/**
	 * 删除文章
	 * @param  string $id [文章ID]
	 * @return [type]     [description]
	 */
	public function postDeleteAll(Request $req) {
		try {
			$ids = $req->input('ids');
			Article::whereIn('id', $ids)->delete();
			return $this->resData(200, '删除成功！');
		} catch (\Throwable $e) {
			return $this->resData(500, '删除失败，请稍后再试！');
		}
	}
	/**
	 * 单条排序
	 * @param  string $id [文章ID]
	 * @return [type]     [description]
	 */
	public function postSort(Request $req) {
		try {
			$validator = Validator::make($req->input(), [
				'article_id' => 'required',
				'sort' => 'required',

			]);
			$attrs = array(
				'article_id' => '文章ID',
				'sort' => '排序',
			);
			$validator->setAttributeNames($attrs);
			if ($validator->fails()) {
				// 如果有错误，提示第一条
				return $this->resData(400, $validator->errors()->all()[0] . '...');
			}
			$id = $req->input('id');
			$sort = $req->input('sort');
			Article::where('id', $id)->update(['sort' => $sort]);
			return $this->resData(200, '排序成功！');
		} catch (\Throwable $e) {
			return $this->resData(500, '排序失败，请稍后再试！');
		}
	}
}
