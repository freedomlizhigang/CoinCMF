<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('admins', function(Blueprint $table)
		{
			$table->foreign('section_id', 'admins_ibfk_1')->references('id')->on('sections')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('section_id', 'admins_ibfk_2')->references('id')->on('sections')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('admins', function(Blueprint $table)
		{
			$table->dropForeign('admins_ibfk_1');
			$table->dropForeign('admins_ibfk_2');
		});
	}

}
