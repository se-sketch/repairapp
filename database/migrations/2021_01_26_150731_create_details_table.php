<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->id();

            $table->unsignedBigInteger('detailable_id'); //->index();
            $table->string('detailable_type');
            $table->index(['detailable_id', 'detailable_type']);
            //$table->morphs('detailable');


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
        Schema::table('details', function (Blueprint $table) {
            
            //$table->dropForeign(['receipt_id']);

            //$table->dropMorphs('detailable');

            $table->dropIndex(['detailable_id', 'detailable_type']);

            $table->dropForeign(['nomenclature_id']);

        });

        Schema::dropIfExists('details');
    }
}
