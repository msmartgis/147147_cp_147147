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
            $table->bigInteger('session_id')->unsigned();
            $table->integer('num_ordre');
            $table->date('date_reception');
            $table->text('objet_fr');
            $table->text('objet_ar');
            $table->double('montant_global');
            $table->text('observation');
            $table->string('decision');
            $table->string('etat');
            $table->tinyInteger('is_affecter');

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
