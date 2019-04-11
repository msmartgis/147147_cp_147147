<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppelOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appel_offres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('moa_id')->unsigned()->nullable();
            $table->bigInteger('adjiducataire_id')->unsigned()->nullable();
            $table->integer('numero')->nullable();
            $table->string('objet_ar')->nullable();
            $table->string('objet_fr')->nullable();
            $table->date('date_publication')->nullable();
            $table->date('date_ouverture_plis')->nullable();
            $table->double('montant_globale')->nullable();
            $table->double('caution_provisoir')->nullable();
            $table->double('caution_definitive')->nullable();
            $table->integer('is_attribuer')->nullable();
            $table->string('etat')->nullable();
            $table->string('ordre_service')->nullable();
            $table->string('delai_execution')->nullable();
            $table->double('montant_adjiducation');
            $table->date('date_commencement');
            $table->timestamps();
            $table->index(['id', 'created_at','numero']);

            $table->foreign('moa_id')
                ->references('id')
                ->on('moas')
                ->onDelete('cascade');

            $table->foreign('adjiducataire_id')
                ->references('id')
                ->on('adjiducataires')
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
        Schema::dropIfExists('appel_offres');
    }
}
