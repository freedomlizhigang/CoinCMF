<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:42:08
 * @Description: 权限菜单表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:24:11
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104208_create_menu_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('parentid')->default(0)->comment('父 ID');
            $table->string('arrparentid')->nullable()->default('0')->comment('所有父 ID');
            $table->boolean('child')->default(0)->comment('是否有子栏目');
            $table->text('arrchildid', 16777215)->nullable()->comment('所有子栏目');
            $table->string('name', 20)->comment('菜单名称');
            $table->string('url', 100)->comment('菜单链接地址');
            $table->string('label', 100)->comment('权限菜单 label')->index('label');
            $table->string('icon', 50)->nullable()->comment('图标');
            $table->boolean('display')->default(1)->comment('是否显示，1 显示，0 隐藏');
            $table->integer('sort')->default(0)->comment('排序，正序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
}
