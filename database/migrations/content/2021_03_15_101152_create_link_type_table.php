<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2021-03-15 10:11:52
 * @Description: 友情链接分类表
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 10:12:31
 * @FilePath: /CoinCMF/database/migrations/2021_03_15_101152_create_link_type_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 100)->default('')->comment('名称');
            $table->tinyInteger('del_flag')->default(0)->comment('删除状态:1 已删除 ，0 正常');
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
        Schema::dropIfExists('link_types');
    }
}
