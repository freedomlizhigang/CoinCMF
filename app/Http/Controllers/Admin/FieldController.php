<?php

namespace App\Http\Controllers\Admin;

use App\Customize\Func;
use App\Http\Controllers\Controller;
use App\Http\Requests\FieldRequest;
use App\Models\Console\Model;
use App\Models\Console\ModelField;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Schema;

class FieldController extends Controller
{
    // 字段管理
    public function getIndex($id)
    {
        try {
            $title = '字段管理';
            $list = ModelField::where('model_id',$id)->orderBy('sort','asc')->orderBy('id','asc')->get();
            return view('admin.console.field.index',compact('title','list','id'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 添加字段
    public function getAdd($id)
    {
        try {
            $title = '添加字段';
            return view('admin.console.field.add',compact('title','id'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(FieldRequest $req,$id)
    {
        // 添加，事务
        DB::beginTransaction();
        try {
            $data = $req->input('data');
            // 生成对就的表里的字段，找出来模型，表里最后一个字段
            $before = ModelField::with('model')->where('model_id',$id)->where('sort','>=',$data['sort'])->orderBy('sort','asc')->orderBy('id','desc')->first();
            // 查字段是否存在
            if (Schema::hasColumn($before->model->tablename,$data['field_name'])) {
                // 出错回滚
                DB::rollBack();
                return $this->adminJson(0,'字段名称已经存在！');
            }
            // 注入字段
            Schema::table($before->model->tablename, function (Blueprint $table) use($data,$before) {
                $type = "";
                switch ($data['type']) {
                    case 'linkage':
                        $table->string($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'files':
                        $table->json($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'box':
                        $table->string($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'datetime':
                        $table->timestamp($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'album':
                        $table->json($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'thumb':
                        $table->string($data['field_name'],255)->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'password':
                        $table->string($data['field_name'],255)->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'number':
                        // 判断是整数还是小数，是否可以为负值
                        $table->integer($data['field_name'],1000)->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'ueditor':
                        $table->text($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    case 'textarea':
                        $table->string($data['field_name'],1000)->nullable()->after($before->field_name)->comment($data['title']);
                        break;

                    default:
                        $table->string($data['field_name'])->nullable()->after($before->field_name)->comment($data['title']);
                        break;
                }
            });
            // 字段配置信息
            $option = $req->input('option',null);
            // 处理选项下的值们
            if ($data['type'] == 'box') {
                //  = Func::processKeyword($option['values'])
                $values = $option['values'];
                // 替换特殊字符
                $values = trim(str_replace('@','',str_replace('_', '', $values)));
                $values = explode(PHP_EOL, $values);
                $tmp = [];
                foreach ($values as $k) {
                    if (trim($k) != '' ) {
                        $kk = explode('|',$k);
                        $tmp[][$kk[0]] = $kk[1];
                    }
                }
                if (count($tmp) === 0) {
                    // 出错回滚
                    DB::rollBack();
                    return $this->adminJson(0,'选项列表不能为空！');
                }
                // 处理为json
                $option['values'] = $tmp;
            }
            $data['option'] = json_encode($option);
            $data['model_id'] = $id;
            // 记录到数据库里
            $model_field = ModelField::create($data);
            DB::commit();
            return $this->adminJson(1,'添加成功！');
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            // return $this->adminJson(0,$e->getMessage());
            return $this->adminJson(0,'添加失败，请稍后再试！');
        }
    }
    // 修改资料
    public function getEdit($id)
    {
        try{
            $title = '修改字段';
            $info = Model::findOrFail($id);
            return view('admin.console.model.edit',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postEdit(ModelRequest $req,$id)
    {
        try {
            $data = $req->input('data');
            Model::where('id',$id)->update($data);
            return $this->adminJson(1,'修改成功！');
        } catch (\Throwable $e) {
            return $this->adminJson(0,'修改失败，请稍后再试！');
        }
    }
    // 删除
    public function getDel($id)
    {
        try {
            // 正常情况下，要先判断字段下是否有对应的内容
            Model::where('id',$id)->update(['del_flag'=>1]);
            return back()->with('message', '删除成功！');
        } catch (\Throwable $e) {
            return back()->with('message', '删除失败！');
        }
    }
}
