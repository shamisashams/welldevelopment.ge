<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableAddTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('new_collection')->default(0)->nullable();
            $table->boolean('bunker')->default(0)->nullable();
            $table->boolean('day_price')->default(0)->nullable();
            $table->boolean('day_product')->default(0)->nullable();
            $table->boolean('special_price_tag')->default(0)->nullable();
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('new_collection');
            $table->dropColumn('bunker');
            $table->dropColumn('day_price');
            $table->dropColumn('day_product');
            $table->dropColumn('special_price_tag');
        });
    }
}
