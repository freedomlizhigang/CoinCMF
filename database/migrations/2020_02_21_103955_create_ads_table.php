<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ads', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('pos_id')->default(0)->comment('位置ID');
			$table->string('title')->default('')->comment('标题');
			$table->string('thumb')->default('')->comment('图片');
			$table->string('url')->default('')->comment('链接');
			$table->dateTime('starttime')->nullable()->comment('开始时间');
			$table->dateTime('endtime')->nullable()->comment('结束时间');
			$table->integer('sort')->default(0)->comment('排序');
			$table->boolean('status')->default(1)->comment('状态，1正常0关闭');
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
		Schema::drop('ads');
	}

}
