<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->id();

            $table->unsignedBigInteger('order_material_id')->nullable(false); //->index();
            $table->foreign('order_material_id')->references('id')->on('order_materials');

            $table->unsignedBigInteger('nomenclature_id')->nullable(false); //->index();
            $table->foreign('nomenclature_id')->references('id')->on('nomenclatures');

            $table->unsignedDecimal('qty', 14, 3)->nullable(false);

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
        Schema::table('order_details', function (Blueprint $table) {
            
            $table->dropForeign(['order_material_id']);

            $table->dropForeign(['nomenclature_id']);

        });
        
        Schema::dropIfExists('order_details');
    }
}
