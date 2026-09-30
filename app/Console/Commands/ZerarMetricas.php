<?php

namespace App\Console\Commands;

use App\Models\Evento;
use Illuminate\Console\Command;

/**
 * Apaga os eventos registrados.
 *
 * Existe porque os primeiros dias de um site novo acumulam ruído — testes
 * do próprio dono, health checks, robôs — e esses números atrapalham mais
 * do que informam. Zerar antes de divulgar faz a contagem significar algo
 * desde o primeiro visitante real.
 */
class ZerarMetricas extends Command
{
    protected $signature = 'metricas:zerar {--force : Não pedir confirmação}';

    protected $description = 'Apaga visitas e cliques registrados';

    public function handle(): int
    {
        $total = Evento::count();

        if ($total === 0) {
            $this->info('Não há eventos para apagar.');

            return self::SUCCESS;
        }

        $visitas = Evento::where('tipo', Evento::TIPO_VISITA)->count();
        $cliques = Evento::where('tipo', Evento::TIPO_CLIQUE)->count();

        $this->line("Registrados hoje: {$visitas} visitas e {$cliques} cliques.");

        // A confirmação é pulada em ambiente não interativo (deploy, cron).
        if (! $this->option('force') && ! $this->confirm('Apagar tudo? Não dá para desfazer.')) {
            $this->info('Cancelado.');

            return self::SUCCESS;
        }

        Evento::query()->delete();

        $this->info("{$total} eventos apagados. A contagem recomeça agora.");

        return self::SUCCESS;
    }
}
