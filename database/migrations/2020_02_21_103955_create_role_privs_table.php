<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolePrivsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_privs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('role_id')->index('ix_role_privs_role_id');
			$table->integer('menu_id');
			$table->string('name', 20);
			$table->string('url', 100)->index('ix_role_privs_url');
			$table->string('label', 100)->index('ix_role_privs_label');
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
		Schema::drop('role_privs');
	}

}
