<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptOfMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_of_materials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->id();
            //$table->string('name')->nullable(false);

            //$table->boolean('active')->default('true');
            $table->boolean('active');

            $table->unsignedBigInteger('user_id')->nullable(false); //->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('subdivision_id')->nullable(false); //->index();
            $table->foreign('subdivision_id')->references('id')->on('subdivisions');


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
            
            $table->dropForeign(['user_id']);

            $table->dropForeign(['subdivision_id']);
            
        });

        Schema::dropIfExists('receipt_of_materials');
    }
}
