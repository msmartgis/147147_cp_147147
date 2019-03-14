n<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('demandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('session_id')->unsigned()->nullable();
            $table->integer('num_ordre')->nullable();
            $table->date('date_reception')->nullable();
            $table->text('objet_fr')->nullable();
            $table->text('objet_ar')->nullable();
            $table->double('montant_global')->nullable();
            $table->text('observation')->nullable();
            $table->string('decision')->nullable();
            $table->string('etat')->nullable();
            $table->tinyInteger('is_affecter')->nullable();
            $table->integer('porteur_projet_id')->unsigned()->nullable();

            $table->softDeletes(); // <-- This will add a deleted_at field
            $table->timestamps();

            $table->index(['session_id', 'created_at','num_ordre']);

            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
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
        Schema::dropIfExists('demandes');
    }
}
