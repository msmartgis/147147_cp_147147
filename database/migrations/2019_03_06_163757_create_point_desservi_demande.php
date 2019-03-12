<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointDesserviDemande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pointdesservi_demande', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('point_desservi_id');
            $table->bigInteger('demande_id');
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
        Schema::dropIfExists('=pointdesservi_demande');
    }
}
