<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuiviVersementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('partenaire_id')->unsigned()->nullable();
            $table->integer('convention_id')->unsigned()->nullable();
            $table->double('montant')->nullable();
            $table->date('date_versement')->nullable();
            $table->integer('prise_en_charge')->nullable(); //oui :1 non : 0
            $table->string('document')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();

            $table->foreign('partenaire_id')
                ->references('id')
                ->on('partenaires_types')
                ->onDelete('cascade');

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
        Schema::dropIfExists('versements');
    }
}
