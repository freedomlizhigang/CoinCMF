<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategorysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categorys', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('parentid');
			$table->string('arrparentid')->default('0');
			$table->boolean('child');
			$table->text('arrchildid', 65535);
			$table->string('name', 50);
			$table->string('thumb')->nullable();
			$table->string('title')->nullable()->comment('标题');
			$table->string('keyword')->nullable()->comment('关键字');
			$table->text('describe', 65535)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('cate_tpl', 50)->default('list')->comment('模板');
			$table->string('art_tpl', 50)->default('show')->comment('文章模板');
			$table->boolean('display')->default(1)->comment('1显示，0不显示');
			$table->boolean('type')->default(0);
			$table->integer('sort')->default(0);
			$table->char('url', 50)->index('ix_categorys_url');
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
		Schema::drop('categorys');
	}

}
