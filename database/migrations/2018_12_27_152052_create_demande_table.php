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
        Schema::create('projets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('num_ordre');
            $table->date('date_reception');
            $table->string('objet_fr', 300);
            $table->string('objet_ar', 300);
            $table->double('montant_global', 9, 2);
            $table->text('observation');
            $table->string('decision', 100);
            $table->string('etat_projet', 100);
            $table->boolean('is_affecter');
            $table->string('type_projet', 100);//demande ,convention ou projet
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
        Schema::dropIfExists('projets');
    }
}
