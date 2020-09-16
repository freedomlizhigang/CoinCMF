<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('admin_id')->index('ix_logs_admin_id');
			$table->string('user', 50);
			$table->string('method', 20);
			$table->string('url', 200);
			$table->string('action_name')->nullable()->comment('操作名');
			$table->text('data', 65535)->nullable();
			$table->text('res_data', 65535)->nullable()->comment('返回值');
			$table->dateTime('created_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs');
	}

}
