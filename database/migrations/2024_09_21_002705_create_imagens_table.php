<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute a migração.
     */
    public function up(): void
    {
        Schema::create('imagens', function (Blueprint $table) {
            $table->id();
            $table->string('nome');        // Nome do arquivo da imagem
            $table->text('imagem');        // Armazena a string em base64 da imagem
            $table->decimal('valor', 8, 2); // Coluna para armazenar um valor numérico, ex: preço
            $table->timestamps();
        });
    }

    /**
     * Reverte a migração.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagens');
    }
};
