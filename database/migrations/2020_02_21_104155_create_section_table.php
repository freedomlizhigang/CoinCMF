<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:41:55
 * @Description: 部门表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:23:22
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104155_create_section_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 20);
            $table->boolean('status')->default(1)->comment('1 正常，0 禁用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
}
