<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-21 11:24:20
 * @Description: 系统配置信息
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-19 22:24:39
 * @FilePath: /CoinCMF/database/migrations/2020_02_21_112420_create_config_table.php
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('config', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('sitename', 200)->nullable()->comment('站点名称');
            $table->string('describe', 500)->nullable()->comment('描述');
            $table->string('person', 100)->nullable()->comment('联系人');
            $table->string('phone', 200)->nullable()->comment('联系电话');
            $table->string('email', 200)->nullable()->comment('邮箱');
            $table->string('address', 500)->nullable()->comment('地址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
}
