<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuppIdIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // Supprimer la clé étrangère 'illustration_id' de 'composants_illustrations'
         Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->dropForeign(['illustration_id']); // Assurez-vous que c'est le nom correct
            $table->dropColumn('illustration_id');
        });

        // Modifier la table 'illustrations'
        Schema::table('illustrations', function (Blueprint $table) {
            $table->dropColumn('id'); // Supprimer la colonne 'id'
            $table->primary('image_path'); // Définir 'image_path' comme clé primaire
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recréer 'id' et 'illustration_id' et restaurer les clés étrangères
        Schema::table('illustrations', function (Blueprint $table) {
            $table->id()->first(); // Recréer 'id'
            $table->dropPrimary(['image_path']); // Supprimer 'image_path' comme clé primaire
        });
        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->unsignedBigInteger('illustration_id');
            $table->foreign('illustration_id')->references('id')->on('illustrations');
        });
    }
}
