<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorteurProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porteurs_projets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('nom_porteur_fr')->nullable();
            $table->string('nom_porteur_ar')->nullable();
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
        Schema::dropIfExists('porteurs_projets');
    }
}
