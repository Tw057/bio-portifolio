@props([
    'whatsapp' => '#',
    // null esconde o ícone da rede — o default não pode ser truthy,
    // senão uma rede não configurada continua aparecendo.
    'github'   => null,
    'linkedin' => null,
    'instagram'=> null,
    'twitter'  => null,
    'nome'     => 'Thiago',
    'cargo'    => 'Desenvolvedor de Software · PHP / Laravel',
    'avatar'   => 'img/avatar.jpg',
])

@php
    // Só renderiza a foto se o arquivo existir de fato — evita ícone quebrado.
    $temAvatar = file_exists(public_path($avatar));
@endphp

<section class="relative isolate flex items-center overflow-hidden lg:min-h-[100svh]">

    {{-- ── Fundo: gradiente que respira + grid técnico ───────────────── --}}
    <div aria-hidden="true" class="absolute inset-0 -z-10">
        {{-- halo ciano/esmeralda --}}
        <div class="absolute -top-1/4 left-1/2 h-[46rem] w-[46rem] -translate-x-1/2 rounded-full
                    bg-[radial-gradient(circle,rgba(45,212,167,.13),transparent_65%)]
                    blur-3xl animate-drift"></div>
        {{-- halo violeta, contraponto frio --}}
        <div class="absolute -bottom-1/3 right-0 h-[34rem] w-[34rem] rounded-full
                    bg-[radial-gradient(circle,rgba(124,92,255,.10),transparent_65%)]
                    blur-3xl animate-drift [animation-delay:-7s]"></div>
        {{-- malha sutil, com fade nas bordas --}}
        <div class="absolute inset-0 opacity-[.35]
                    [background-image:linear-gradient(rgba(255,255,255,.045)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.045)_1px,transparent_1px)]
                    [background-size:64px_64px]
                    [mask-image:radial-gradient(ellipse_at_center,black_35%,transparent_78%)]"></div>
    </div>

    <div class="mx-auto w-full max-w-6xl px-5 py-14 sm:px-6 sm:py-20 lg:px-8 lg:py-28">
        <div class="grid items-center gap-10 sm:gap-14 lg:grid-cols-12 lg:gap-12">

            {{-- ══ COLUNA ESQUERDA — a mensagem ═══════════════════════ --}}
            <div class="min-w-0 lg:col-span-7">

                {{-- 0. Identidade: avatar redondo com borda em gradiente --}}
                <div class="animate-fade-up mb-6 flex items-center gap-3.5 sm:mb-8 sm:gap-4">
                    <div class="relative shrink-0">
                        {{-- anel colorido atrás da foto --}}
                        <div aria-hidden="true"
                             class="absolute -inset-[3px] rounded-full bg-gradient-to-tr from-accent via-cyan-400 to-violet-500 opacity-90 blur-[1px]"></div>

                        @if ($temAvatar)
                            {{-- WebP com fallback: 6 KB contra 10 KB do JPEG,
                                 e o navegador antigo ainda recebe a imagem. --}}
                            <picture>
                                <source srcset="{{ asset('img/avatar.webp') }}" type="image/webp">
                                <img src="{{ asset($avatar) }}"
                                     alt="Foto de {{ $nome }}"
                                     width="72" height="72" loading="eager" decoding="async" fetchpriority="high"
                                     class="relative h-[72px] w-[72px] rounded-full object-cover object-top ring-2 ring-ink">
                            </picture>
                        @else
                            <div class="relative flex h-[72px] w-[72px] items-center justify-center rounded-full
                                        bg-panel text-xl font-bold text-slate-400 ring-2 ring-ink"
                                 role="img" aria-label="Foto de {{ $nome }} ainda não adicionada">
                                {{ mb_substr($nome, 0, 1) }}
                            </div>
                        @endif

                        {{-- selo de disponibilidade --}}
                        <span class="absolute -bottom-0.5 -right-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-ink">
                            <span class="h-3 w-3 rounded-full bg-accent ring-2 ring-ink"></span>
                        </span>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[15px] font-semibold text-white">{{ $nome }}</p>
                        <p class="mt-0.5 font-mono text-[12.5px] leading-snug text-slate-500 sm:text-[13px]">
                            {{-- No celular o cargo quebraria em duas linhas com uma órfã:
                                 corta no separador e mostra só a primeira parte. --}}
                            <span class="sm:hidden">{{ trim(explode('·', $cargo)[0]) }}</span>
                            <span class="hidden sm:inline">{{ $cargo }}</span>
                        </p>
                    </div>
                </div>

                {{-- 1. Linha de status --}}
                <div class="animate-fade-up inline-flex items-center gap-2.5 rounded-full
                            border border-line bg-panel/70 px-4 py-1.5 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent opacity-70"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-accent"></span>
                    </span>
                    <span class="text-[13px] font-medium tracking-wide text-slate-400">
                        Sistemas, sites e lojas sob medida
                    </span>
                </div>

                {{-- 2. Título --}}
                <h1 class="animate-fade-up [animation-delay:80ms] mt-6 sm:mt-8
                           text-[2.35rem] font-extrabold leading-[1.06] tracking-[-0.03em] text-white
                           sm:text-6xl lg:text-[4.15rem]">
                    Software que resolve
                    <span class="bg-gradient-to-r from-accent via-cyan-300 to-violet-400 bg-clip-text text-transparent">
                        problemas reais
                    </span>
                </h1>

                {{-- 3. Subtítulo --}}
                <p class="animate-fade-up [animation-delay:160ms] mt-5 max-w-xl text-[15.5px] leading-relaxed text-slate-400 sm:mt-7 sm:text-lg">
                    Resolvo <span class="font-medium text-slate-200">dores de negócio</span> através
                    de software. Sistemas, sites e lojas sob medida — do banco de dados à tela.
                </p>

                {{-- 4 e 5. CTAs --}}
                <div data-cta-referencia
                     class="animate-fade-up [animation-delay:240ms] mt-8 flex flex-col gap-3 sm:mt-11 sm:flex-row sm:items-center">
                    <a href="{{ $whatsapp }}"
                       target="_blank" rel="noopener noreferrer"
                       class="group inline-flex items-center justify-center gap-2.5 rounded-xl
                              bg-accent px-7 py-4 text-[15px] font-semibold text-ink
                              shadow-[0_0_0_0_rgba(45,212,167,.45)]
                              transition-all duration-300 hover:-translate-y-0.5 hover:bg-emerald-300
                              hover:shadow-[0_10px_38px_-10px_rgba(45,212,167,.65)]
                              focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4
                              focus-visible:outline-accent">
                        <span aria-hidden="true" class="transition-transform duration-300 group-hover:-translate-y-0.5">🚀</span>
                        Fazer um orçamento
                    </a>

                    <a href="#diagnostico"
                       class="inline-flex items-center justify-center gap-2 rounded-xl
                              border border-line bg-panel/50 px-7 py-4 text-[15px] font-medium text-slate-300
                              backdrop-blur-sm transition-colors duration-300
                              hover:border-slate-600 hover:text-white
                              focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4
                              focus-visible:outline-slate-500">
                        Como eu resolvo
                        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v9.19l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3.75A.75.75 0 0 1 10 3Z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>


                {{-- 6. Redes sociais --}}
                <div class="animate-fade-up [animation-delay:320ms] mt-9 flex items-center gap-0.5 sm:mt-12 sm:gap-1">
                    <span class="mr-3 hidden text-xs uppercase tracking-[0.18em] text-slate-600 sm:block">Onde me achar</span>

                    @php
                        $redes = [
                            ['nome' => 'GitHub',   'url' => $github,    'path' => 'M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2Z'],
                            ['nome' => 'LinkedIn', 'url' => $linkedin,  'path' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286ZM5.337 7.433a2.062 2.062 0 1 1 0-4.125 2.062 2.062 0 0 1 0 4.125Zm1.782 13.019H3.555V9h3.564v11.452ZM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003Z'],
                            ['nome' => 'Instagram','url' => $instagram, 'path' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z'],
                            ['nome' => 'Twitter',  'url' => $twitter,   'path' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z'],
                        ];
                    @endphp

                    @foreach ($redes as $rede)
                        @continue(! $rede['url'])
                        <a href="{{ $rede['url'] }}" target="_blank" rel="noopener noreferrer"
                           aria-label="{{ $rede['nome'] }}"
                           class="flex h-11 w-11 items-center justify-center rounded-lg text-slate-500 transition-colors duration-200
                                  hover:bg-panel hover:text-accent
                                  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                  focus-visible:outline-accent">
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="{{ $rede['path'] }}"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- ══ COLUNA DIREITA — terminal (glassmorphism) ══════════ --}}
            <div class="animate-fade-up [animation-delay:400ms] min-w-0 lg:col-span-5">
                <div class="relative">
                    {{-- brilho por trás do card --}}
                    <div aria-hidden="true"
                         class="absolute -inset-px rounded-2xl bg-gradient-to-br from-accent/25 via-transparent to-violet-500/20 blur-[2px]"></div>

                    <div class="relative overflow-hidden rounded-2xl border border-line bg-panel/80 shadow-2xl backdrop-blur-xl">
                        {{-- barra da janela --}}
                        <div class="flex items-center gap-2 border-b border-line/80 px-4 py-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#FF5F57]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#FEBC2E]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#28C840]"></span>
                            <span class="ml-2 font-mono text-[11px] text-slate-600">Projeto.php</span>
                        </div>

                        {{--
                          Código decorativo com efeito de digitação.
                          A fonte fica em um <template>: o JS clona linha a linha
                          para dentro do <code>. Sem JS, o @noscript abaixo mostra
                          o bloco completo — o conteúdo nunca depende do script.
                        --}}
                        <template data-typewriter-source>
                            <div><span class="text-violet-400">class</span> <span class="text-cyan-300">Projeto</span> <span class="text-slate-500">{</span></div>
                            <div>    <span class="text-violet-400">public function</span> <span class="text-accent">entregar</span><span class="text-slate-500">(</span><span class="text-cyan-300">Dor</span> <span class="text-orange-300">$dor</span><span class="text-slate-500">): </span><span class="text-cyan-300">Resultado</span></div>
                            <div>    <span class="text-slate-500">{</span></div>
                            <div>        <span class="text-violet-400">return</span> <span class="text-orange-300">$dor</span></div>
                            <div>            <span class="text-slate-500">-></span><span class="text-accent">mapear</span><span class="text-slate-500">()</span></div>
                            <div>            <span class="text-slate-500">-></span><span class="text-accent">arquitetar</span><span class="text-slate-500">()</span></div>
                            <div>            <span class="text-slate-500">-></span><span class="text-accent">testar</span><span class="text-slate-500">()</span></div>
                            <div>            <span class="text-slate-500">-></span><span class="text-accent">colocarNoAr</span><span class="text-slate-500">();</span></div>
                            <div>    <span class="text-slate-500">}</span></div>
                            <div><span class="text-slate-500">}</span></div>
                        </template>

                        <pre aria-hidden="true" class="w-full overflow-x-auto px-5 py-5 font-mono text-[11.5px] leading-[1.85] sm:text-[13px]"><code data-typewriter class="block min-h-[196px] whitespace-pre"><noscript><div><span class="text-violet-400">class</span> <span class="text-cyan-300">Projeto</span> <span class="text-slate-500">{</span></div><div>    <span class="text-violet-400">public function</span> <span class="text-accent">entregar</span><span class="text-slate-500">(</span><span class="text-cyan-300">Dor</span> <span class="text-orange-300">$dor</span><span class="text-slate-500">): </span><span class="text-cyan-300">Resultado</span></div><div>    <span class="text-slate-500">{</span></div><div>        <span class="text-violet-400">return</span> <span class="text-orange-300">$dor</span></div><div>            <span class="text-slate-500">-></span><span class="text-accent">mapear</span><span class="text-slate-500">()</span></div><div>            <span class="text-slate-500">-></span><span class="text-accent">arquitetar</span><span class="text-slate-500">()</span></div><div>            <span class="text-slate-500">-></span><span class="text-accent">testar</span><span class="text-slate-500">()</span></div><div>            <span class="text-slate-500">-></span><span class="text-accent">colocarNoAr</span><span class="text-slate-500">();</span></div><div>    <span class="text-slate-500">}</span></div><div><span class="text-slate-500">}</span></div></noscript></code><span class="ml-0.5 inline-block w-[7px] animate-blink bg-accent align-middle text-transparent">.</span></pre>

                        {{-- rodapé: stack --}}
                        <div class="flex flex-wrap items-center gap-2 border-t border-line/80 px-5 py-3.5">
                            @foreach (['Laravel', 'PHP 8', 'PostgreSQL', 'Redis', 'Docker'] as $tech)
                                <span class="rounded-md border border-line bg-ink/60 px-2.5 py-1 font-mono text-[11px] text-slate-400">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
