<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunePointsDesservisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_desservis', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('categorie_point_id')->references('id')->on('point_desservi_categories');
            $table->string('nom_ar', 500);
            $table->string('nom_fr', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_desservis');
    }
}
