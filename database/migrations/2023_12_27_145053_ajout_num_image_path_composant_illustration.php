<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutNumImagePathComposantIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modifier la table 'composants_illustrations'
        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->unsignedBigInteger('numero'); // Ajouter la colonne 'numero'
            $table->string('image_path_id'); // Ajouter la colonne 'image_path_id'
            $table->foreign('image_path_id')->references('image_path')->on('illustrations'); // Clé étrangère vers 'image_path' dans 'illustrations'
            $table->primary(['image_path_id', 'numero']); // Clé primaire composite
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
            $table->dropPrimary(['image_path_id', 'numero']); // Supprimer la clé primaire composite
            $table->dropForeign(['image_path_id']); // Supprimer la contrainte de clé étrangère
            $table->dropColumn('image_path_id'); // Supprimer la colonne 'image_path_id'
            $table->dropColumn('numero'); // Supprimer la colonne 'numero'
        });
    }
}
