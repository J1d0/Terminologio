<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutDomainIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('illustrations', function (Blueprint $table) {
            $table->string('domain')->nullable(); // Ajout de la colonne 'domain'
            $table->foreign('domain')->references('nom')->on('domaines'); // Ajout de la clé étrangère
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('illustrations', function (Blueprint $table) {
            $table->dropForeign(['domain']); // Supprimer la contrainte de clé étrangère
            $table->dropColumn('domain'); // Supprimer la colonne 'domain'
        });
    }
}
