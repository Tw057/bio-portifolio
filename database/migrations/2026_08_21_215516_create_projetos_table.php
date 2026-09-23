<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->text('descricao');

            // Guardados como JSON: são listas curtas que só este projeto usa.
            // Uma tabela separada para cada uma seria complexidade sem retorno.
            $table->json('stack')->default('[]');
            $table->json('metricas')->default('[]');

            $table->string('repo')->nullable();
            $table->string('demo')->nullable();
            $table->boolean('demo_aberta')->default(false);

            // Rascunho não aparece no site; serve para escrever aos poucos.
            $table->boolean('publicado')->default(true);

            // Menor primeiro. Novos projetos entram no fim da lista.
            $table->unsignedInteger('ordem')->default(0);

            $table->timestamps();

            // A home filtra por publicado e ordena por ordem: índice composto.
            $table->index(['publicado', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
