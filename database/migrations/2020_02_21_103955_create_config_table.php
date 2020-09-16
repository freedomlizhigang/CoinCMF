<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('config', function(Blueprint $table)
		{
			$table->integer('id', true);
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
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('config');
	}

}
