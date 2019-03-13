<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommuneDemandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commune_demande', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('commune_id')->nullable();
            $table->bigInteger('demande_id')->nullable();
            $table->timestamps();

            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commune_demande');
    }
}
