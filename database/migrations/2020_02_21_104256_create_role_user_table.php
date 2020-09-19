<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:42:56
 * @Description: 角色-管理员对应表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:23:38
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104256_create_role_user_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('role_id');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_users');
    }
}
