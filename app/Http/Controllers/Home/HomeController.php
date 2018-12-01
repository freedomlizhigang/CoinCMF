<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Common\Article;
use Illuminate\Http\Request;
use LaravelFormBuilder\Form;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $req)
    {
        return view('home.home');
    }
    public function test()
    {
        //input组件
        $input = Form::input('goods_name','商品名称');

        //日期区间选择组件
        $dateRange = Form::dateRange(
            'limit_time',
            '区间日期',
            strtotime('- 10 day'),
            time()
        );

        //省市二级联动组件
        $cityArea = Form::city('address','收货地址',[
            '陕西省','西安市'
        ]);

        $checkbox = Form::checkbox('label','表单',[])->options([
            ['value'=>'1','label'=>'好用','disabled'=>true],
            ['value'=>'2','label'=>'方便','disabled'=>true]
        ])->col(Form::col(12));

        $tree = Form::treeChecked('tree','权限',[])->data([
            Form::treeData(11,'leaf 1-1-1')->children([Form::treeData(13,'131313'),Form::treeData(14,'141414')]),
            Form::treeData(12,'leaf 1-1-2')
        ])->col(Form::col(12)->xs(12));

        //创建form
        $form = Form::create('/save.php',[
            $input,$dateRange,$cityArea,$checkbox,$tree
        ]);

        $html = $form->formRow(Form::row(10))->setMethod('get')->setTitle('编辑商品')->view();

        return view('home.form',compact('html'));
    }
}
