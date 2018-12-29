<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourceFinancementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sourcesFinancements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source', 500);
            $table->string('reference', 500);
            $table->string('abreviation', 500);
            $table->double('montant_total', 9, 2);
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
        Schema::dropIfExists('sourcesFinancements');
    }
}
