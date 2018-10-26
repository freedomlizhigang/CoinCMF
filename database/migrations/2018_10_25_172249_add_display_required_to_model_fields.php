<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayRequiredToModelFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_fields', function (Blueprint $table) {
            $table->tinyInteger('required_flag')->default(0)->after('option')->comment('必填：1 是，0 否');
            $table->tinyInteger('display_flag')->default(1)->after('required_flag')->comment('显示：1 是，0 否');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_fields', function (Blueprint $table) {
            //
        });
    }
}
