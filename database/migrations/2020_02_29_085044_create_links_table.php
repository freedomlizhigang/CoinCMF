<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-29 08:50:44
 * @Description: 友情链接
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-16 10:13:44
 * @FilePath: /CoinCMF/database/migrations/2020_02_29_085044_create_links_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('linktype_id')->default(0)->comment('分类ID');
            $table->string('title')->default('')->comment('标题');
            $table->string('thumb')->default('')->nullable()->comment('图片');
            $table->string('url')->default('')->comment('链接');
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
        Schema::dropIfExists('links');
    }
}
