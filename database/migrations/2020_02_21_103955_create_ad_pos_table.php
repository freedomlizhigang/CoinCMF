<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdPosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ad_pos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->boolean('is_mobile')->default(0)->comment('0:PC/1:MOB');
			$table->string('name', 100)->default('')->comment('名称');
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
		Schema::drop('ad_pos');
	}

}
