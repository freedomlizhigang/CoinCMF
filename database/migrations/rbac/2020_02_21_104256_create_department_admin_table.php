<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:42:56
 * @Description: 角色-管理员对应表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 10:07:23
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104256_create_department_admin_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentAdminTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('department_admins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('department_id');
            $table->integer('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_admins');
    }
}
