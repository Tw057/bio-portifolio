<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    // A tabela só tem created_at: um evento nunca é atualizado.
    public const UPDATED_AT = null;

    protected $fillable = [
        'tipo', 'destino', 'referrer', 'dispositivo', 'visitante_hash',
    ];

    public const TIPO_VISITA = 'visita';
    public const TIPO_CLIQUE = 'clique';
}
