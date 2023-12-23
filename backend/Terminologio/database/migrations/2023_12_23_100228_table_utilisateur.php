<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableUtilisateur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id(); // sert de clé primaire
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('membre'); // Rôle avec une valeur par défaut 'membre'
            $table->timestamps(); // enregistrer date et heures modifications table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
}
