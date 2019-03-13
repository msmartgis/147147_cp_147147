<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammesProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes_projet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('programme_id')->nullable();
            $table->bigInteger('projet_id')->nullable();
            $table->timestamps();

            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programmes_projet');
    }
}
