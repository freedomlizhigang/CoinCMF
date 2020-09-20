<?php

declare(strict_types=1);

namespace App\Controller\Console\Content;

use App\Model\Content\Link;
use App\Annotation\JsonAnnotation;
use App\Controller\AbstractController;
use App\Request\Content\LinkIdRequest;
use App\Request\Content\LinkCreateRequest;

/** 
 * 引入 json 格式化注解，在 Aspect 中处理
 * @JsonAnnotation()
 */
class LinkController extends AbstractController
{
    public function getList()
    {
        try {
            $key = $this->request->input('key', '');
            $page = $this->request->input('page', 1);
            $size = $this->request->input('size', 10);
            $list = Link::where(function ($q) use ($key) {
                        if ($key != '') {
                            $q->where('title', 'like', '%'.$key.'%');
                        }
                    })->where('is_del',0)->limit($size)->offset(($page - 1) * $size)->orderBy('sort', 'desc')->orderBy('id', 'desc')->get();
            $count = Link::where(function ($q) use ($key) {
                        if ($key != '') {
                            $q->where('title', 'like', '%$key%');
                        }
                    })->where('is_del', 0)->count();
            $res = ['list' => $list, 'count' => $count];
            return [200, '获取数据成功...', $res];
        } catch (\Throwable $e) {
            return [500, '获取数据失败，请稍后再试...'];
        }
    }
    public function postCreate(LinkCreateRequest $req)
    {
        try {
            $data = $req->validated();
            $create = ['title' => $data['title'], 'thumb' => $data['thumb'], 'url' => $data['url'], 'sort' => $data['sort'], 'status' => $data['status'] == 'true' ? 1 : 0];
            Link::create($create);
            return [200, '添加成功！'];
        } catch (\Throwable $e) {
            return [500, '添加失败，请稍后再试！'];
        }
    }
    public function postDetail(LinkIdRequest $req)
    {
        try {
            $data = $req->validated();
            $id = $data['link_id'];
            $link = Link::findOrFail($id);
            return [200, '查询成功', $link];
        } catch (\Throwable $e) {
            return [500, '查询失败，请稍后再试！'];
        }
    }
    public function postEdit(LinkCreateRequest $req)
    {
        try {
            $data = $req->validated();
            $id = $data['link_id'];
            $update = ['title' => $data['title'], 'thumb' => $data['thumb'], 'url' => $data['url'], 'sort' => $data['sort'], 'status' => $data['status'] == 'true' ? 1 : 0];
            Link::where('id', $id)->update($update);
            return [200, '修改成功！'];
        } catch (\Throwable $e) {
            return [500, '修改失败，请稍后再试！'];
        }
    }
    public function postRemove(LinkIdRequest $req)
    {
        try {
            $data = $req->validated();
            $id = $data['link_id'];
            Link::where('id', $id)->update(['is_del'=>1]);
            return [200, '删除完成！'];
        } catch (\Throwable $e) {
            return [500, '删除失败，请稍后再试'];
        }
    }
    public function postSort(LinkIdRequest $req)
    {
        try {
            $data = $req->validated();
            $id = $data['link_id'];
            Link::where('id', $id)->update(['sort'=>$this->request->input('sort',0)]);
            return [200, '排序成功！'];
        } catch (\Throwable $e) {
            return [500, '排序失败，请稍后再试！'];
        }
    }
}
