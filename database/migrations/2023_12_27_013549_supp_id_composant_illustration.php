<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuppIdComposantIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Supprimer la clé étrangère et la colonne 'composant_id' de la table 'traductions'
        Schema::table('traductions', function (Blueprint $table) {
            $table->dropForeign(['composant_id']); // Assurez-vous que c'est le nom correct
            $table->dropColumn('composant_id');
        });

        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->dropColumn('id'); // Supprime la colonne 'id'
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
            $table->id()->first(); // Recrée la colonne 'id' en cas de rollback
        });

        // Recréer la colonne 'composant_id' et la clé étrangère dans 'traductions'
        Schema::table('traductions', function (Blueprint $table) {
            $table->unsignedBigInteger('composant_id')->nullable();
            $table->foreign('composant_id')->references('id')->on('composants_illustrations');
        });
    }
}
