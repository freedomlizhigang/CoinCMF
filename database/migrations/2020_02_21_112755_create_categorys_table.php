<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 11:27:55
 * @Description: 栏目表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:25:03
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_112755_create_categorys_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('parentid')->default(0)->comment('父 ID');
            $table->string('arrparentid')->nullable()->default('0')->comment('所有父 ID');
            $table->boolean('child')->default(0)->comment('是否有子栏目');
            $table->text('arrchildid', 16777215)->nullable()->comment('所有子栏目');
            $table->string('name', 150)->default('栏目')->comment('栏目名称');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keyword')->nullable()->comment('关键字');
            $table->string('describe',500)->nullable()->comment('描述');
            $table->text('content')->nullable()->comment('内容');
            $table->boolean('link_flag')->default(0)->comment('是否外部链接：1是，0否');
            $table->char('url',200)->index('url')->nullable()->comment('链接 URL');
            $table->string('cate_tpl', 50)->default('list')->comment('栏目显示模板，列表 list，单页 page');
            $table->string('art_tpl', 50)->default('show')->comment('下属文章模板');
            $table->boolean('display')->default(1)->comment('1显示，0不显示');
            $table->boolean('type')->default(0)->comment('类型，0 列表，1 单页');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorys');
    }
}
