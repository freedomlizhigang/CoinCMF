<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('parentid');
			$table->string('arrparentid')->nullable()->default('0');
			$table->boolean('child')->default(0);
			$table->text('arrchildid', 16777215)->nullable();
			$table->string('name', 20);
			$table->string('url', 100);
			$table->string('label', 100);
			$table->string('icon', 50)->nullable();
			$table->boolean('display')->default(1);
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
		Schema::drop('menus');
	}

}
