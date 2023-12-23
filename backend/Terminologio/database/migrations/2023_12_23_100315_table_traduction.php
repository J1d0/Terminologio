<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableTraduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('composant_id'); // Référence au composant de l'illustration
            $table->string('langue'); // Langue de la traduction
            $table->text('texte'); // Texte de la traduction
            $table->foreign('composant_id')->references('id')->on('composants_illustrations'); // Clé étrangère
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
        Schema::dropIfExists('traductions');
    }
}
