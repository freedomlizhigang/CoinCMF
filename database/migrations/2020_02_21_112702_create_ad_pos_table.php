<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 11:27:02
 * @Description: 广告位迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:23:57
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_112702_create_ad_pos_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ad_pos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->boolean('is_mobile')->default(0)->comment('0:PC/1:MOB');
            $table->string('name', 100)->default('')->comment('名称');
            $table->tinyInteger('is_del')->default(0)->comment('删除状态:1 已删除 ，0 正常');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_pos');
    }
}
