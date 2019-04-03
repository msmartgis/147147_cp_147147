<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToConventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conventions', function (Blueprint $table) {
            $table->foreign('programme_id')
                ->references('id')
                ->on('programmes')
                ->onDelete('cascade');

            $table->foreign('moa_id')
                ->references('id')
                ->on('moas')
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
            //
        });
    }
}
