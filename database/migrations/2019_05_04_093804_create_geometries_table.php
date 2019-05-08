<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeometriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geometries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('piste_id')->unsigned();
            $table->longText('geometry');
            $table->timestamps();
            $table->index(['piste_id', 'created_at','id']);

            $table->foreign('piste_id')
                ->references('id')
                ->on('pistes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geometries');
    }
}
