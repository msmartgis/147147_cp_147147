<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conventions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('session_id')->unsigned();
            $table->bigInteger('demande_id')->unsigned();
            $table->integer('num_ordre');
            $table->date('date_reception');
            $table->text('objet_fr');
            $table->text('objet_ar');
            $table->double('montant_global');
            $table->text('observation');
            $table->string('decision');
            $table->tinyInteger('is_affecter');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['session_id','demande_id','created_at','num_ordre']);

            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
                ->onDelete('cascade');

            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
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
        Schema::dropIfExists('conventions');
    }
}
