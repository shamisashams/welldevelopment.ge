<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatailTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('detail_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();

            $table->unique(['detail_id','locale']);
            $table->foreign('detail_id')
                ->references('id')
                ->on('details')
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
        Schema::dropIfExists('detail_translations');
    }
}
