<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 11:27:40
 * @Description: 文章表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-06-10 16:16:42
 * @FilePath: /CoinCMF/database/migrations/content/2020_02_21_112740_create_article_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('cate_id')->index('cate_id');
            $table->string('title');
            $table->string('keywords')->nullable()->default('')->comment('关键字');
            $table->string('thumb', 200)->nullable()->comment('缩略图');
            $table->string('describe', 500)->nullable()->comment('描述信息');
            $table->text('content')->nullable()->comment('内容');
            $table->string('tpl', 50)->default('show')->comment('默认模板文件');
            $table->boolean('push_flag')->default(0)->comment('1推荐，0不推荐');
            $table->string('source', 50)->nullable()->comment('来源');
            $table->boolean('link_flag')->default(0)->comment('是否外部链接：1是，0否');
            $table->char('url',200)->index('url')->comment('链接 URL');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('hits')->default(99)->comment('点击量');
            $table->dateTime('publish_at')->useCurrent()->comment('发布时间');
            $table->boolean('del_flag')->default(0)->comment('1删除，0正常');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
}
