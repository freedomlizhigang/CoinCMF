<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 10:42:21
 * @Description: 管理员表迁移文件
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:23:31
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_104221_create_admin_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('section_id')->comment('所在部门');
            $table->string('name', 20)->unique('name')->comment('用户名');
            $table->string('realname', 100)->nullable()->comment('真实姓名');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('phone', 20)->nullable()->comment('手机号');
            $table->char('crypt', 10)->nullable()->comment('秘钥');
            $table->char('password',50)->comment('密码');
            $table->ipAddress('lastip')->nullable()->default('0.0.0.0')->comment('最后登录 IP');
            $table->dateTime('lasttime')->nullable()->comment('最后登录时间');
            $table->boolean('status')->default(1)->comment('状态，1 正常，0 禁用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
}
