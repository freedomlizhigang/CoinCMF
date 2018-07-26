<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeywordsPsuhFlagDelFlagToArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('keywords')->default('')->nullable()->comment('关键字')->after('title');
            // $table->integer('hits')->default(99)->comment('点击量')->after('sort');
            // $table->tinyInteger('push_flag')->default(0)->comment('1推荐，0不推荐')->after('publish_at');
            // $table->tinyInteger('del_flag')->default(0)->comment('1删除，0正常')->after('tpl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
}
