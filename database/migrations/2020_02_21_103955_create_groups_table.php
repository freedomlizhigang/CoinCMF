<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 30)->comment('用户组名');
			$table->integer('points')->default(1000)->comment('所需积分');
			$table->integer('discount')->default(100)->comment('折扣');
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
		Schema::drop('groups');
	}

}
