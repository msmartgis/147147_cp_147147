<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTableProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function ($table) {
            $table->string('objet_fr', 300)->nullable()->change();
            $table->string('objet_ar', 300)->nullable()->change();
            $table->float('montant_global', 8, 2)->nullable()->change();
            $table->text('observation')->nullable()->change();
            $table->string('decision', 300)->nullable()->change();
            $table->string('etat_projet', 300)->nullable()->change();
            $table->boolean('is_affecter')->nullable()->change();
            $table->string('type_projet', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
