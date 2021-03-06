<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conventions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('session_id')->unsigned()->nullable();
            $table->bigInteger('demande_id')->unsigned()->nullable();
            $table->bigInteger('programme_id')->unsigned()->nullable();
            $table->bigInteger('moa_id')->unsigned()->nullable();
            $table->bigInteger('appel_offre_id')->unsigned()->nullable();
            $table->text('objet_fr')->nullable();
            $table->text('objet_ar')->nullable();
            $table->double('montant_global')->nullable();
            $table->text('observation')->nullable();
            $table->string('decision')->nullable();
            $table->tinyInteger('is_project')->nullable(); // to know if it is project version cp or version partner
            $table->string('annee')->nullable();
            $table->bigInteger('organisation_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['session_id','demande_id','created_at']);

            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
                ->onDelete('cascade');

            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
                ->onDelete('cascade');

            $table->foreign('appel_offre_id')
                ->references('id')
                ->on('appel_offres')
                ->onDelete('cascade');

            $table->foreign('organisation_id')
                ->references('id')
                ->on('organisations')
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
        Schema::dropIfExists('conventions');
    }
}
