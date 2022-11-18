<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApartmentsAddRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('apartments', function (Blueprint $table) {
            $table->integer('rooms')->default(0);
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
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
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn('rooms');
            $table->dropColumn('bedrooms');
            $table->dropColumn('bathrooms');
        });
    }
}
