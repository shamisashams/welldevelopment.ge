<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApartmentsAddFloor extends Migration
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
            $table->json('floors')->nullable();
            $table->float('area')->default(0);
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
            $table->dropColumn('floors');
            $table->dropColumn('area');
        });
    }
}
