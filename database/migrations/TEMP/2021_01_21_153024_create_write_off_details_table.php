<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWriteOffDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('write_off_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->id();

            $table->unsignedBigInteger('write_off_id')->nullable(false); //->index();
            $table->foreign('write_off_id')->references('id')->on('write_off_of_materials');

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
        Schema::table('write_off_details', function (Blueprint $table) {
            
            $table->dropForeign(['write_off_id']);

            $table->dropForeign(['nomenclature_id']);

        });
                
        Schema::dropIfExists('write_off_details');
    }
}
