<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('nom')->nullable();
            $table->string('path')->nullable();
            $table->bigInteger('demande_id')->unsigned()->nullable();
            $table->bigInteger('convention_id')->unsigned()->nullable();
            $table->timestamps();

            $table->index(['id','created_at']);
            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
                ->onDelete('cascade');

            $table->foreign('convention_id')
                ->references('id')
                ->on('conventions')
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
        Schema::dropIfExists('pieces');
    }
}
