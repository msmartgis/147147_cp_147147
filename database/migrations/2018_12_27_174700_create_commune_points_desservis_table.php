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
        Schema::create('pointsDesservis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_point', 500);
            $table->string('nom_ar', 500);
            $table->string('nom_fr', 500);
            $table->geometry('coordonnees');
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
        Schema::dropIfExists('pointsDesservis');
    }
}
