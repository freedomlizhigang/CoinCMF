<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 11:27:12
 * @Description: 广告表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:24:47
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_112712_create_ads_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('pos_id')->default(0)->comment('位置ID');
            $table->string('title')->default('')->comment('标题');
            $table->string('thumb')->default('')->comment('图片');
            $table->string('url')->default('')->comment('链接');
            $table->dateTime('starttime')->useCurrent()->comment('开始时间');
            $table->dateTime('endtime')->useCurrent()->comment('结束时间');
            $table->integer('sort')->default(0)->comment('排序');
            $table->boolean('status')->default(1)->comment('状态，1正常0关闭');
            $table->tinyInteger('del_flag')->default(0)->comment('删除状态:1 已删除 ，0 正常');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
}
