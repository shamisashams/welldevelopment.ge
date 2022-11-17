<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectsAddCityId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function (Blueprint $table) {

            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('district_id')->unsigned();
            $table->index(['city_id','district_id']);
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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('projects_city_id_district_id_index');
            $table->dropColumn('city_id');
            $table->dropColumn('district_id');
        });
    }
}
