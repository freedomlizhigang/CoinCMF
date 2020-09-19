<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:42:33
 * @Description: 管理员操作日志迁移表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:24:22
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104233_create_log_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('admin_id')->index('admin_id')->default(0)->comment('管理员 ID');
            $table->string('user', 50)->nullable()->comment('管理员用户名');
            $table->string('method', 20)->comment('操作类型');
            $table->string('url')->comment('请求地址');
            $table->string('action_name')->nullable()->comment('操作名');
            $table->text('data')->nullable()->comment('请求数据');
            $table->text('res_data')->nullable()->comment('返回值');
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
}
