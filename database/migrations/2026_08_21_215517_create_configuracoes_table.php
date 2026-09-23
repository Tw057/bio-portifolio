<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Chave-valor: os dados de contato são poucos e não se relacionam
        // entre si. Uma coluna por campo exigiria migration a cada campo novo.
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->string('chave')->primary();
            $table->text('valor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};
