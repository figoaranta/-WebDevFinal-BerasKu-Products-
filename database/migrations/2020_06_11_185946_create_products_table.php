<?php

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
            $table->bigIncrements('id');
            $table->char('riceGradeType',1)->index();
            $table->foreign('riceGradeType')->references('riceGradeType')->on('riceGradeTypes');
            $table->string('riceType')->index();
            $table->foreign('riceType')->references('riceType')->on('riceTypes');
            $table->string('riceShapeType')->index();
            $table->foreign('riceShapeType')->references('riceShapeType')->on('riceShapeTypes');
            $table->string('riceColorType')->index();
            $table->foreign('riceColorType')->references('riceColorType')->on('riceColorTypes');
            $table->string('riceTextureType')->index();
            $table->foreign('riceTextureType')->references('riceTextureType')->on('riceTextureTypes');
            $table->Integer('riceQuantity');
            $table->string('riceUnitType')->index();
            $table->foreign('riceUnitType')->references('riceUnitType')->on('riceUnitTypes');
            $table->integer('price');
            $table->timestamps();
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
