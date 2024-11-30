<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutTroisClesPrimTraduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('traductions', function (Blueprint $table) {
            $table->dropColumn('id'); // Supprimer la colonne 'id'
            $table->unsignedBigInteger('composant_num'); // Ajouter la colonne 'composant_num'
            $table->string('image_path_id'); // Ajouter la colonne 'image_path_id'
            $table->foreign('image_path_id')->references('image_path')->on('illustrations'); // Clé étrangère vers 'image_path' dans 'illustrations'
            $table->primary(['image_path_id', 'composant_num', 'langue']); // Clé primaire composite
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('traductions', function (Blueprint $table) {
            $table->dropPrimary(['image_path_id', 'composant_num', 'langue']); // Supprimer la clé primaire composite
            $table->dropForeign(['image_path_id']); // Supprimer la contrainte de clé étrangère
            $table->dropColumn(['image_path_id', 'composant_num']);
            $table->id()->first(); // Recréer la colonne 'id'
        });
    }
}
