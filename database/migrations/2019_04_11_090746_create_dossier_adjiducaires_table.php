<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDossierAdjiducairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossier_adjiducataires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document')->nullable();
            $table->string('file_name')->nullable();
            $table->bigInteger('appel_offre_id')->unsigned()->nullable();
            $table->timestamps();
            $table->index(['id', 'created_at']);

            $table->foreign('appel_offre_id')
                ->references('id')
                ->on('appel_offres')
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
        Schema::dropIfExists('dossier_adjiducataires');
    }
}
