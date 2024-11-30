<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutCoordComposantIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ajout des attributs x et y à la table 'composants_illustrations'
        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->float('x');
            $table->float('y');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Suppression des attributs x et y de la table 'composants_illustrations'
        Schema::table('composants_illustrations', function (Blueprint $table) {
            $table->dropColumn('x');
            $table->dropColumn('y');
        });
    }
}
