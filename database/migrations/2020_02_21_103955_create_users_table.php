<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('gid')->default(1)->comment('组ID');
			$table->char('openid')->nullable()->index('ix_users_openid');
			$table->string('username', 30)->nullable()->comment('用户名');
			$table->string('password', 200)->nullable()->comment('密码');
			$table->string('token')->nullable()->comment('API登陆用');
			$table->string('phone', 20)->nullable()->comment('手机号');
			$table->string('nickname', 30)->nullable()->comment('昵称');
			$table->string('thumb')->nullable()->comment('头像');
			$table->string('email', 100)->nullable()->comment('邮箱');
			$table->boolean('sex')->default(0)->comment('性别');
			$table->string('birthday', 25)->nullable()->comment('生日');
			$table->string('address', 200)->nullable()->comment('地址');
			$table->boolean('status')->default(1)->comment('状态，1正常0禁用');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
