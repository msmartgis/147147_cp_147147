<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourceFinancementConventionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sourcefinancement_convention', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sourceFinancement')->nullable();
            $table->bigInteger('id_convention')->nullable();
            $table->double('montant')->nullable();
            $table->timestamps();

            $table->index(['id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sourcefinancement_convention');
    }
}
