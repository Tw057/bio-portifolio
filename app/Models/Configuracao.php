<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Configuracao extends Model
{
    protected $table = 'configuracoes';
    protected $primaryKey = 'chave';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['chave', 'valor'];

    private const CACHE_KEY = 'configuracoes.todas';

    /**
     * Todas as configurações como array simples.
     * Fica em cache porque a home lê isso a cada visita e o valor
     * muda só quando você salva o painel.
     */
    public static function todas(): array
    {
        return Cache::rememberForever(
            self::CACHE_KEY,
            fn () => static::pluck('valor', 'chave')->all()
        );
    }

    public static function obter(string $chave, ?string $padrao = null): ?string
    {
        return static::todas()[$chave] ?? $padrao;
    }

    /** Grava várias de uma vez e limpa o cache. */
    public static function gravar(array $valores): void
    {
        foreach ($valores as $chave => $valor) {
            static::updateOrCreate(['chave' => $chave], ['valor' => $valor]);
        }

        Cache::forget(self::CACHE_KEY);
    }
}
