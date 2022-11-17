<?php
/**
 *  database/migrations/2021_07_30_062827_create_products_table.php
 *
 * Date-Time: 30.07.21
 * Time: 10:28
 * @author Insite LLC <hello@insite.international>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            //$table->bigInteger('category_id')->unsigned();

            $table->string('slug')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
