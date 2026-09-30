<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Projeto;
use App\Services\Rastreador;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PainelController extends Controller
{
    public function index(Request $request, Rastreador $rastreador): View
    {
        $desde = Carbon::now()->subDays(30)->startOfDay();

        return view('admin.painel', [
            'navegadorIgnorado' => $request->cookie(Rastreador::COOKIE_DONO) === $rastreador->assinaturaDono(),

            'totalProjetos' => Projeto::count(),
            'projetosNoAr'  => Projeto::where('publicado', true)->count(),

            'visitas30d'    => $this->reais()
                ->where('tipo', Evento::TIPO_VISITA)
                ->where('created_at', '>=', $desde)
                ->count(),

            'visitantes30d' => $this->reais()
                ->where('tipo', Evento::TIPO_VISITA)
                ->where('created_at', '>=', $desde)
                ->distinct('visitante_hash')
                ->count('visitante_hash'),

            'cliques30d'    => $this->reais()
                ->where('tipo', Evento::TIPO_CLIQUE)
                ->where('created_at', '>=', $desde)
                ->count(),

            'cliquesPorDestino' => $this->reais()
                ->where('tipo', Evento::TIPO_CLIQUE)
                ->where('created_at', '>=', $desde)
                ->select('destino', DB::raw('count(*) as total'))
                ->groupBy('destino')
                ->orderByDesc('total')
                ->get(),

            'origens' => $this->reais()
                ->where('created_at', '>=', $desde)
                ->whereNotNull('referrer')
                ->select('referrer', DB::raw('count(*) as total'))
                ->groupBy('referrer')
                ->orderByDesc('total')
                ->limit(8)
                ->get(),

            'dispositivos' => $this->reais()
                ->where('created_at', '>=', $desde)
                ->select('dispositivo', DB::raw('count(*) as total'))
                ->groupBy('dispositivo')
                ->get(),

            'porDia' => $this->reais()
                ->where('tipo', Evento::TIPO_VISITA)
                ->where('created_at', '>=', Carbon::now()->subDays(13)->startOfDay())
                ->select(DB::raw('date(created_at) as dia'), DB::raw('count(*) as total'))
                ->groupBy('dia')
                ->orderBy('dia')
                ->get(),
        ]);
    }

    /**
     * Apaga os eventos registrados.
     *
     * Os primeiros dias acumulam ruído — testes do próprio dono, health
     * checks, robôs. Zerar antes de divulgar faz a contagem significar
     * algo desde o primeiro visitante real.
     */
    public function zerar(): RedirectResponse
    {
        $total = Evento::count();

        Evento::query()->delete();

        return back()->with('sucesso', "{$total} registros apagados. A contagem recomeça agora.");
    }

    /**
     * Base de toda métrica: robô não é gente.
     * Metade do tráfego da web é automatizado — sem filtrar, o número mente.
     */
    private function reais(): Builder
    {
        return Evento::query()->where('dispositivo', '!=', 'bot');
    }
}
