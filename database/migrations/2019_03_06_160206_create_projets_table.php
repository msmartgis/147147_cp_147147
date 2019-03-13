<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetsTable extends Migration
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
            $table->bigInteger('convention_id')->unsigned()->nullable();
            $table->integer('num_ordre')->nullable();
            $table->text('objet_fr')->nullable();
            $table->text('objet_ar')->nullable();
            $table->double('montant_global')->nullable();
            $table->double('longueur')->nullable();
            $table->double('etat_avancement')->nullable();
            $table->string('annee')->nullable();
            $table->timestamps();
            $table->index(['convention_id', 'created_at','num_ordre']);

            $table->foreign('convention_id')
                ->references('id')
                ->on('conventions')
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
        Schema::dropIfExists('projets');
    }
}
