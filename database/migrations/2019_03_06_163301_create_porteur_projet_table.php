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
        Schema::create('porteursprojets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('nom_porteur_fr');
            $table->string('nom_porteur_ar');
            $table->bigInteger('demande_id')->unsigned();
            $table->timestamps();

            $table->index(['id','created_at']);

            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
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
        Schema::dropIfExists('porteursprojets');
    }
}
