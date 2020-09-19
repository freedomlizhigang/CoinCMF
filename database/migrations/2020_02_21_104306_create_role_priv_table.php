<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:43:06
 * @Description: 角色权限表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:24:31
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104306_create_role_priv_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePrivTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_privs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('role_id')->index('role_id')->comment('角色 ID');
            $table->integer('menu_id')->comment('菜单 ID');
            $table->string('name', 20)->comment('菜单名称');
            $table->string('url', 100)->index('url')->comment('链接 url');
            $table->string('label', 100)->index('label')->comment('权限 label');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_privs');
    }
}
