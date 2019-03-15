<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->integer('etat_projet_id')->unsigned();

            $table->foreign('etat_projet_id')
                ->references('id')
                ->on('etat_projets')
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
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn(['etat_projet_id']);
            $table->dropForeign('etat_projets_etat_projet_id_foreign');
        });
    }
}
