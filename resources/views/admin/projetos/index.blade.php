@extends('admin.layout')

@section('titulo', 'Projetos')

@section('conteudo')

    <header class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Projetos</h1>
            <p class="mt-1.5 text-[14px] text-slate-500">
                A ordem aqui é a ordem que aparece no site.
            </p>
        </div>

        <a href="{{ route('admin.projetos.create') }}"
           class="rounded-lg bg-accent px-4 py-2.5 text-[14px] font-semibold text-ink
                  transition-colors hover:bg-emerald-300
                  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent">
            + Novo projeto
        </a>
    </header>

    @if ($projetos->isEmpty())
        <div class="rounded-xl border border-dashed border-line bg-panel/30 px-6 py-16 text-center">
            <p class="text-[15px] text-slate-400">Nenhum projeto cadastrado.</p>
            <p class="mt-2 text-[13.5px] text-slate-600">Clique em "Novo projeto" para começar.</p>
        </div>
    @else
        <ul class="space-y-3">
            @foreach ($projetos as $projeto)
                <li class="flex items-start gap-4 rounded-xl border border-line bg-panel/50 p-5">

                    {{-- Reordenar --}}
                    <div class="flex shrink-0 flex-col gap-1">
                        @foreach ([['cima', '↑', $loop->first], ['baixo', '↓', $loop->last]] as [$direcao, $seta, $desabilitado])
                            <form method="POST" action="{{ route('admin.projetos.mover', $projeto) }}">
                                @csrf
                                <input type="hidden" name="direcao" value="{{ $direcao }}">
                                <button type="submit"
                                        @disabled($desabilitado)
                                        aria-label="Mover para {{ $direcao }}"
                                        class="flex h-6 w-6 items-center justify-center rounded border border-line
                                               text-[12px] text-slate-500 transition-colors
                                               hover:border-slate-600 hover:text-white
                                               disabled:cursor-not-allowed disabled:opacity-25 disabled:hover:border-line">
                                    {{ $seta }}
                                </button>
                            </form>
                        @endforeach
                    </div>

                    {{-- Dados --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h2 class="text-[15px] font-semibold text-white">{{ $projeto->titulo }}</h2>

                            @unless ($projeto->publicado)
                                <span class="rounded border border-amber-500/30 bg-amber-500/10 px-2 py-0.5
                                             font-mono text-[10.5px] uppercase text-amber-400/90">Rascunho</span>
                            @endunless

                            @if ($projeto->demo_aberta)
                                <span class="rounded-full border border-accent/30 bg-accent/10 px-2 py-0.5
                                             text-[10.5px] text-accent">Demo aberta</span>
                            @endif
                        </div>

                        <p class="mt-2 line-clamp-2 text-[13.5px] leading-relaxed text-slate-400">
                            {{ $projeto->descricao }}
                        </p>

                        @if ($projeto->stack)
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($projeto->stack as $tech)
                                    <span class="rounded border border-line bg-ink/60 px-1.5 py-0.5
                                                 font-mono text-[10.5px] text-slate-500">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Ações --}}
                    <div class="flex shrink-0 items-center gap-2">
                        <a href="{{ route('admin.projetos.edit', $projeto) }}"
                           class="rounded-lg border border-line px-3 py-1.5 text-[13px] text-slate-400
                                  transition-colors hover:border-slate-600 hover:text-white">
                            Editar
                        </a>

                        <form method="POST" action="{{ route('admin.projetos.destroy', $projeto) }}"
                              onsubmit="return confirm('Excluir &quot;{{ $projeto->titulo }}&quot;? Não dá para desfazer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-lg border border-line px-3 py-1.5 text-[13px] text-slate-500
                                           transition-colors hover:border-red-500/50 hover:text-red-400">
                                Excluir
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
