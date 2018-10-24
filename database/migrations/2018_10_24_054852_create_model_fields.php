<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->default(0)->comment('模型ID');
            $table->enum('type',['id','text','textarea','ueditor','number','password','thumb','album','datetime','box','files','linkage'])->default('text')->comment('字段类型，text单行文本，textarea多行文本，ueditor富文本，number数字，password密码，thumb单图，album多图，datetime时间，box选项（radio单选，checkbox多选，select下拉框，multiple多选列表框），files文件，linkage联动菜单（分类，radio单选，checkbox多选，select下拉框，multiple多选列表框）');
            $table->string('field_name',255)->comment('字段名');
            $table->string('title',255)->comment('字段别名');
            $table->string('tips',255)->nullable()->comment('错误提示');
            $table->string('validation',255)->nullable()->comment('验证规则');
            $table->json('option')->nullable()->comment('其它配置');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态：1 正常，0 禁用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_fields');
    }
}
