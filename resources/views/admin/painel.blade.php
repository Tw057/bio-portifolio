@extends('admin.layout')

@section('titulo', 'Visão geral')

@section('conteudo')

    <header class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Visão geral</h1>
            <p class="mt-1.5 text-[14px] text-slate-500">Últimos 30 dias · robôs não entram na conta</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            @if ($navegadorIgnorado)
                <span class="inline-flex items-center gap-2 rounded-full border border-accent/25 bg-accent/10
                             px-3 py-1.5 text-[12.5px] text-accent"
                      title="As suas visitas e cliques neste navegador não entram nos números.">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                        <path fill-rule="evenodd" d="M.664 10.59a1.65 1.65 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"/>
                    </svg>
                    Você não está sendo contado
                </span>
            @endif

            <form method="POST" action="{{ route('admin.metricas.zerar') }}"
                  onsubmit="return confirm('Apagar todas as visitas e cliques registrados? Não dá para desfazer.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="rounded-lg border border-line px-3 py-1.5 text-[12.5px] text-slate-500
                               transition-colors hover:border-red-500/40 hover:text-red-400
                               focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                               focus-visible:outline-slate-500">
                    Zerar métricas
                </button>
            </form>
        </div>
    </header>

    {{-- ── Números principais ───────────────────────────────── --}}

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['rotulo' => 'Visitas',        'valor' => $visitas30d,    'nota' => 'páginas abertas'],
            ['rotulo' => 'Visitantes',     'valor' => $visitantes30d, 'nota' => 'pessoas distintas'],
            ['rotulo' => 'Cliques',        'valor' => $cliques30d,    'nota' => 'em links rastreados'],
            ['rotulo' => 'Projetos no ar', 'valor' => $projetosNoAr,  'nota' => "de {$totalProjetos} cadastrados"],
        ] as $cartao)
            <div class="rounded-xl border border-line bg-panel/50 p-5">
                <p class="font-mono text-[11px] uppercase tracking-[0.15em] text-slate-600">{{ $cartao['rotulo'] }}</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-white">{{ $cartao['valor'] }}</p>
                <p class="mt-1.5 text-[12.5px] text-slate-500">{{ $cartao['nota'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Diagnóstico: distingue "ninguém veio" de "o registro quebrou" --}}
    <section class="mt-6 rounded-xl border border-line bg-panel/30 px-5 py-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="font-mono text-[11px] uppercase tracking-[0.15em] text-slate-600">
                Diagnóstico
            </p>
            <p class="font-mono text-[12px] text-slate-500">
                {{ $totalBruto }} {{ $totalBruto === 1 ? 'registro' : 'registros' }} no banco (sem filtro)
            </p>
        </div>

        @if ($ultimoEvento)
            <p class="mt-2.5 text-[13px] text-slate-400">
                Último: <span class="text-slate-200">{{ $ultimoEvento->tipo }}</span>
                @if ($ultimoEvento->destino)
                    → <span class="text-accent">{{ $ultimoEvento->destino }}</span>
                @endif
                · {{ $ultimoEvento->dispositivo }}
                · {{ $ultimoEvento->created_at?->diffForHumans() }}
            </p>
        @else
            <p class="mt-2.5 text-[13px] text-slate-500">
                Nenhum registro ainda. Para testar, abra o site numa aba anônima —
                ela não carrega o cookie que exclui você da contagem.
            </p>
        @endif
    </section>

    {{-- ── Visitas por dia ──────────────────────────────────── --}}

    <section class="mt-6 rounded-xl border border-line bg-panel/50 p-6">
        <h2 class="text-[15px] font-semibold text-white">Visitas nos últimos 14 dias</h2>

        @php $maximo = max(1, $porDia->max('total') ?? 1); @endphp

        @if ($porDia->isEmpty())
            <p class="mt-6 text-[13.5px] text-slate-600">Ainda sem dados. Assim que alguém abrir o site, aparece aqui.</p>
        @else
            <div class="mt-6 flex h-36 items-end gap-1.5">
                @foreach ($porDia as $dia)
                    <div class="group relative flex h-full flex-1 flex-col items-center justify-end">
                        <div class="w-full rounded-t bg-accent/70 transition-colors group-hover:bg-accent"
                             style="height: {{ max(8, round($dia->total / $maximo * 88)) }}%"></div>
                        <span class="mt-2 font-mono text-[10px] text-slate-600">
                            {{ \Illuminate\Support\Carbon::parse($dia->dia)->format('d/m') }}
                        </span>
                        <span class="pointer-events-none absolute -top-6 rounded bg-ink px-2 py-0.5 font-mono text-[11px]
                                     text-white opacity-0 transition-opacity group-hover:opacity-100">
                            {{ $dia->total }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ── Detalhes ─────────────────────────────────────────── --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-3">

        <section class="rounded-xl border border-line bg-panel/50 p-6">
            <h2 class="text-[15px] font-semibold text-white">Cliques por destino</h2>
            @if ($cliquesPorDestino->isEmpty())
                <p class="mt-4 text-[13.5px] text-slate-600">Nenhum clique registrado ainda.</p>
            @else
                <ul class="mt-4 space-y-3">
                    @foreach ($cliquesPorDestino as $item)
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-[13.5px] capitalize text-slate-300">{{ $item->destino }}</span>
                            <span class="font-mono text-[13px] text-accent">{{ $item->total }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="rounded-xl border border-line bg-panel/50 p-6">
            <h2 class="text-[15px] font-semibold text-white">De onde vieram</h2>
            @if ($origens->isEmpty())
                <p class="mt-4 text-[13.5px] text-slate-600">Sem origem externa registrada.</p>
            @else
                <ul class="mt-4 space-y-3">
                    @foreach ($origens as $item)
                        <li class="flex items-center justify-between gap-3">
                            <span class="truncate text-[13.5px] text-slate-300">{{ $item->referrer }}</span>
                            <span class="shrink-0 font-mono text-[13px] text-slate-500">{{ $item->total }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="rounded-xl border border-line bg-panel/50 p-6">
            <h2 class="text-[15px] font-semibold text-white">Dispositivo</h2>
            @if ($dispositivos->isEmpty())
                <p class="mt-4 text-[13.5px] text-slate-600">Sem dados ainda.</p>
            @else
                <ul class="mt-4 space-y-3">
                    @foreach ($dispositivos as $item)
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-[13.5px] capitalize text-slate-300">{{ $item->dispositivo }}</span>
                            <span class="font-mono text-[13px] text-slate-500">{{ $item->total }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>

@endsection
