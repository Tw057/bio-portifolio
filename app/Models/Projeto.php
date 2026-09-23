<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'projetos';

    protected $fillable = [
        'titulo', 'descricao', 'stack', 'metricas',
        'repo', 'demo', 'demo_aberta', 'publicado', 'ordem',
    ];

    protected function casts(): array
    {
        return [
            'stack'       => 'array',
            'metricas'    => 'array',
            'demo_aberta' => 'boolean',
            'publicado'   => 'boolean',
        ];
    }

    /** Só o que deve aparecer no site, já na ordem certa. */
    public function scopeVisiveis(Builder $query): Builder
    {
        return $query->where('publicado', true)->orderBy('ordem');
    }

    /** Próxima posição livre — usado ao criar um projeto novo. */
    public static function proximaOrdem(): int
    {
        return (int) static::max('ordem') + 1;
    }
}
