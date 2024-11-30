<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableComposantIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composants_illustrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('illustration_id'); // Référence à l'illustration
            $table->string('nom'); // Nom du composant
            $table->string('description'); // Description du composant
            $table->foreign('illustration_id')->references('id')->on('illustrations'); // Clé étrangère vers la table illustrations
            $table->timestamps(); // Timestamps pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('composants_illustrations');
    }
}
