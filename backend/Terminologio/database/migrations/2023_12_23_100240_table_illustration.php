<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illustrations', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titre de l'illustration
            $table->string('default_language'); // Langue par défaut de l'illustration
            $table->unsignedBigInteger('user_id'); // Clé étrangère pour l'utilisateur qui a téléversé l'illustration
            $table->string('image_path'); // Chemin de l'image stockée
            $table->foreign('user_id')->references('id')->on('utilisateurs'); // Clé étrangère
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('illustrations'); // pour rollback correct
    }
}
