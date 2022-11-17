<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApartmentsAddAction extends Migration
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
            $table->boolean('offer')->default(0);
            $table->boolean('action')->default(0);
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
            $table->dropColumn('offer');
            $table->dropColumn('action');
        });
    }
}
