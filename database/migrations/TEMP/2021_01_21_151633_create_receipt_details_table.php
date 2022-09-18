<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->id();

            $table->unsignedBigInteger('receipt_id')->nullable(false); //->index();
            $table->foreign('receipt_id')->references('id')->on('receipt_of_materials');

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
        Schema::table('receipt_of_materials', function (Blueprint $table) {
            
            $table->dropForeign(['receipt_id']);

            $table->dropForeign(['nomenclature_id']);

        });

        Schema::dropIfExists('receipt_details');
    }
}
