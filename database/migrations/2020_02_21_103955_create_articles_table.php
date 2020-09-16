<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('cate_id')->index('ix_articles_cate_id');
			$table->string('title');
			$table->string('keywords')->nullable()->default('')->comment('关键字');
			$table->string('thumb', 200)->nullable();
			$table->string('describe', 500)->nullable();
			$table->text('content');
			$table->string('source', 50)->nullable();
			$table->integer('sort')->default(0);
			$table->integer('hits')->default(99)->comment('点击量');
			$table->dateTime('publish_at')->nullable();
			$table->boolean('push_flag')->default(0)->comment('1推荐，0不推荐');
			$table->char('url', 50)->index('ix_articles_url');
			$table->string('tpl', 50)->default('show');
			$table->boolean('del_flag')->default(0)->comment('1删除，0正常');
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
		Schema::drop('articles');
	}

}
