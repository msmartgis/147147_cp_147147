<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointDesserviProjet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pointdesservi_projet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('point_desservi_id')->nullable();
            $table->bigInteger('projet_id')->nullable();
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
        Schema::dropIfExists('pointdesservi_projet');
    }
}
