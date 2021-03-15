<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:41:55
 * @Description: 部门表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 16:24:45
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104155_create_department_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('parentid')->default(0)->comment('父 ID');
            $table->string('arrparentid')->nullable()->default('0')->comment('所有父 ID');
            $table->boolean('child')->default(0)->comment('是否有子部门');
            $table->text('arrchildid', 16777215)->nullable()->comment('所有子部门');
            $table->string('name', 20);
            $table->boolean('status')->default(1)->comment('1 正常，0 禁用');
            $table->boolean('del_flag')->default(0)->comment('删除状态，1 删除，0 未删除');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
}
