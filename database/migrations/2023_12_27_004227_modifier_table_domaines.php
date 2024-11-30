<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifierTableDomaines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domaines', function (Blueprint $table) {
            $table->dropColumn('id'); // Supprimer la colonne id
            $table->string('nom')->primary()->change(); // Définir nom comme clé primaire
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domaines', function (Blueprint $table) {
            $table->id()->first(); // Réajouter la colonne id
            $table->dropPrimary('nom'); // Retirer nom comme clé primaire
        });
    }
}
