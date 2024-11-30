<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuppDescriptionComposantIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->dropColumn('description'); // Suppression de la colonne 'description'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->string('description')->nullable(); // Restaurer la colonne 'description' lors d'un rollback
        });
    }
}
