<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartenaireProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partenaire_projet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partenaire_id')->nullable();
            $table->bigInteger('demande_id')->nullable();
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
        Schema::dropIfExists('partenaire_projet');
    }
}
