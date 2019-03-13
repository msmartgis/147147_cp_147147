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
        Schema::create('sourcesfinancements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source')->nullable();
            $table->string('reference')->nullable();
            $table->string('abreviation')->nullable();
            $table->double('montant_total')->nullable();
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
        Schema::dropIfExists('sourcesfinancements');
    }
}
