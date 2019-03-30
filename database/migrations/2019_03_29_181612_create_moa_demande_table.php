<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoaDemandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moa_demande', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('demande_id')->nullable();
            $table->integer('moa_id')->nullable();
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
        Schema::dropIfExists('moa_demande');
    }
}
