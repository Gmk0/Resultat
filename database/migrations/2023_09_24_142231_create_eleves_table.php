<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        ['nom', 'postnom', 'prenom', 'date_naissance', 'lieu_naissance', 'sexe', 'addresse', 'id_classe'];
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('postnom');
            $table->string('prenom');
            $table->string('date_naissance');
            $table->string('lieu_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->string('addresse', 1000);
            $table->foreignId('id_classe')->constrained();






            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
