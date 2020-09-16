<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique('name');
			$table->string('realname', 100);
			$table->string('email')->nullable();
			$table->integer('section_id')->index('section_id');
			$table->char('crypt', 10)->nullable();
			$table->string('lastip', 15)->nullable()->default('');
			$table->dateTime('lasttime')->nullable()->comment('最后登录时间');
			$table->string('password');
			$table->string('phone', 20)->nullable()->default('');
			$table->boolean('status')->default(1);
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
		Schema::drop('admins');
	}

}
