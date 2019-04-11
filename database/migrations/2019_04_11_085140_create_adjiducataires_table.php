<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjiducatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjiducataires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom_fr')->nullable();
            $table->string('nom_ar')->nullable();
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
        Schema::dropIfExists('adjiducataires');
    }
}
