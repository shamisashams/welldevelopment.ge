<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeOptionTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_option_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribute_option_id')->unsigned();
            $table->string("locale")->index();

            $table->string("label")->nullable();

            $table->unique(['attribute_option_id','locale']);
            $table->foreign('attribute_option_id')
                ->references('id')
                ->on('attribute_options')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_option_translations');
    }
}
