<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            // 'visita' = abriu a home. 'clique' = clicou em um link rastreado.
            $table->string('tipo', 20);

            // Para clique: whatsapp, github, instagram... Nulo em visita.
            $table->string('destino', 40)->nullable();

            // De onde veio (Instagram, Google, direto). Ajuda a saber o que funciona.
            $table->string('referrer')->nullable();

            $table->string('dispositivo', 20)->nullable();   // mobile | desktop | bot

            // IP é dado pessoal (LGPD). Guardamos só o hash com salt da app:
            // permite distinguir visitantes sem identificar ninguém.
            $table->string('visitante_hash', 64)->nullable();

            $table->timestamp('created_at')->nullable();

            $table->index(['tipo', 'created_at']);
            $table->index('destino');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
