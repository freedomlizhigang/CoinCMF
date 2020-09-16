<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('parentid');
			$table->string('arrparentid')->nullable();
			$table->boolean('child')->nullable();
			$table->text('arrchildid', 65535)->nullable();
			$table->string('name', 200);
			$table->integer('sort')->default(0);
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
		Schema::drop('types');
	}

}
