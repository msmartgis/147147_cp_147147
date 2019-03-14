<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdAvancementToConventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conventions', function (Blueprint $table) {
            $table->integer('avancement_id')->unsigned();

            $table->foreign('avancement_id')
                ->references('id')
                ->on('avancement')
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
        Schema::table('conventions', function (Blueprint $table) {
            $table->dropColumn(['avancement_id']);
            $table->dropForeign('avancement_avancement_id_foreign');
        });
    }
}
