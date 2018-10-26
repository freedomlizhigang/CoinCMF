<?php
/*
 * @package [App\Http\Controllers\Admin]
 * @author [李志刚]
 * @createdate  [2018-10-24]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 模型管理
 *
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelRequest;
use App\Models\Console\Model;
use App\Models\Console\ModelField;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Schema;

class ModelController extends Controller
{
    // 模型管理
    public function getIndex(Request $req)
    {
        try {
            $title = '模型管理';
            $list = Model::orderBy('id','desc')->paginate(10);
            return view('admin.console.model.index',compact('title','list'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    // 添加模型
    public function getAdd()
    {
        try {
            $title = '添加模型';
            return view('admin.console.model.add',compact('title'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
    public function postAdd(ModelRequest $req)
    {
        // 添加，事务
        DB::beginTransaction();
        try {
            $data = $req->input('data');
            $model = Model::create($data);
            // 生成数据表
            if (!Schema::hasTable($data['tablename'])) {
                // 对应的字段表里建数据
                $d = date('Y-m-d H:i:s');
                $fields[] = ['model_id'=>$model->id,'type'=>'id','field_name'=>'id','title'=>'ID','display_flag'=>0,'sort'=>0,'created_at'=>$d,'updated_at'=>$d];
                $fields[] = ['model_id'=>$model->id,'type'=>'datetime','field_name'=>'created_at','title'=>'创建时间','display_flag'=>0,'sort'=>999,'created_at'=>$d,'updated_at'=>$d];
                $fields[] = ['model_id'=>$model->id,'type'=>'datetime','field_name'=>'updated_at','title'=>'修改时间','display_flag'=>0,'sort'=>999,'created_at'=>$d,'updated_at'=>$d];
                ModelField::insert($fields);
                Schema::create($data['tablename'], function (Blueprint $table) {
                    $table->increments('id');
                    $table->timestamps();
                });
            }
            else
            {
                DB::rollback();
                return $this->adminJson(0,'数据表已经存在，请换一个名字！');
            }
            DB::commit();
            return $this->adminJson(1,'添加成功！');
        } catch (\Throwable $e) {
            // 出错回滚
            DB::rollBack();
            return $this->adminJson(0,'添加失败，请稍后再试！');
        }
    }
    // 修改资料
    public function getEdit($id)
    {
        try{
            $title = '修改模型';
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
        DB::beginTransaction();
        try {
            // 正常情况下，要先判断模型下是否有对应的表及字段数据
            $tablename = Model::where('id',$id)->value('tablename');
            Schema::dropIfExists($tablename);
            // 删除模型、字段信息
            Model::where('id',$id)->delete();
            ModelField::where('model_id',$id)->delete();
            DB::commit();
            return back()->with('message', '删除成功！');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('message', '删除失败！');
        }
    }
    // 预览
    public function getView($id)
    {
        try {
            $title = '预览模型';
            $info = Model::with(['fields'=>function($q){
                        $q->where('display_flag',1)->orderBy('sort','asc')->orderBy('id','asc');
                    }])->findOrFail($id);
            return view('admin.console.model.view',compact('title','info'));
        } catch (\Throwable $e) {
            return view('errors.500');
        }
    }
}
