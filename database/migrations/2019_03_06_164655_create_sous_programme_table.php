<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSousProgrammeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sousprogrammes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom')->nullable();
            $table->bigInteger('id_projet')->nullable();
            $table->timestamps();

            $table->index(['id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sousprogrammes');
    }
}
