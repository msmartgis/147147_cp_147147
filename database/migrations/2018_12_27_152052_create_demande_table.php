<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeTable extends Migration
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
            $table->integer('num_ordre');
            $table->date('date_reception');
            $table->string('objet_fr', 300)->nullable();
            $table->string('objet_ar', 300)->nullable();
            $table->double('montant_global', 9, 2);
            $table->text('observation');
            $table->string('decision', 100);
            $table->string('etat', 100);
            $table->boolean('is_affecter');
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
        Schema::dropIfExists('demandes');
    }
}
