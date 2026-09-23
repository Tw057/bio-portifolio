@props([
    'titulo',
    'descricao',
    'stack'     => [],
    'metricas'  => [],
    'repo'      => null,
    'demo'      => null,
    'exemplo'   => false,   // marca visualmente que o card é placeholder
    'demoAberta'=> false,   // sinaliza que dá para entrar e mexer no sistema
])

<article class="group relative flex flex-col overflow-hidden rounded-2xl border border-line bg-panel/60
                p-5 backdrop-blur-sm transition-all duration-300 sm:p-6
                hover:-translate-y-1 hover:border-slate-700 hover:bg-panel/90
                focus-within:border-slate-700">

    {{-- brilho no topo, aparece no hover --}}
    <div aria-hidden="true"
         class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/60 to-transparent
                opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

    @if ($exemplo)
        <span class="mb-4 inline-flex w-fit items-center gap-1.5 rounded-md border border-amber-500/30
                     bg-amber-500/10 px-2.5 py-1 font-mono text-[10.5px] uppercase tracking-wider text-amber-400/90">
            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
            </svg>
            Exemplo — substituir
        </span>
    @endif

    @if ($demoAberta)
        <span class="mb-4 inline-flex w-fit items-center gap-2 rounded-full border border-accent/30
                     bg-accent/10 px-3 py-1 text-[11.5px] font-medium text-accent">
            <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent opacity-70"></span>
                <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-accent"></span>
            </span>
            Demo aberta — pode entrar e mexer
        </span>
    @endif

    <h3 class="text-lg font-semibold leading-snug text-white">
        {{ $titulo }}
    </h3>

    <p class="mt-3 flex-1 text-[14.5px] leading-relaxed text-slate-400">
        {{ $descricao }}
    </p>

    @if (count($metricas))
        <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2">
            @foreach ($metricas as $metrica)
                <span class="flex items-center gap-1.5 font-mono text-[11.5px] text-slate-500">
                    <span class="h-1 w-1 rounded-full bg-accent" aria-hidden="true"></span>
                    {{ $metrica }}
                </span>
            @endforeach
        </div>
    @endif

    @if (count($stack))
        <div class="mt-5 flex flex-wrap gap-1.5">
            @foreach ($stack as $tech)
                <span class="rounded-md border border-line bg-ink/60 px-2 py-0.5 font-mono text-[11px] text-slate-400">
                    {{ $tech }}
                </span>
            @endforeach
        </div>
    @endif

    @if ($repo || $demo)
        <div class="-mb-1 mt-5 flex items-center gap-1 border-t border-line/70 pt-3 sm:mt-6 sm:gap-2 sm:pt-4">
            @if ($repo)
                <a href="{{ $repo }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex min-h-[44px] items-center gap-1.5 px-2 text-[13.5px] font-medium text-slate-400
                          transition-colors hover:text-accent
                          focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2Z"/>
                    </svg>
                    Código
                </a>
            @endif

            @if ($demo)
                <a href="{{ $demo }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex min-h-[44px] items-center gap-1.5 px-2 text-[13.5px] font-medium text-slate-400
                          transition-colors hover:text-accent
                          focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/>
                        <path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/>
                    </svg>
                    {{ $demoAberta ? 'Testar o sistema' : 'Ver funcionando' }}
                </a>
            @endif
        </div>
    @endif
</article>
