<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSlidersChangeProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('sliders', function (Blueprint $table) {
            $table->bigInteger('project_id')->unsigned()->nullable()->change();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('sliders', function (Blueprint $table) {
            $table->bigInteger('project_id')->unsigned()->change();


        });
    }
}
