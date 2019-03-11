<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsDesservisTable extends Migration
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
            $table->integer('categorie_point_id')->unsigned();
            $table->string('nom_ar');
            $table->string('nom_fr');
            $table->timestamps();

            $table->index(['id','created_at']);

            $table->foreign('categorie_point_id')
                ->references('id')
                ->on('point_desservi_categories')
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
        Schema::dropIfExists('point_desservis');
    }
}
