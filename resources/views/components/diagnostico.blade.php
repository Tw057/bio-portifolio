@props([
    'telefone' => 'SEU_NUMERO_AQUI',
    'dores'    => [],
])

<section id="diagnostico" class="relative mx-auto max-w-5xl scroll-mt-4 px-5 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-28">

    <header class="mx-auto max-w-2xl text-center">
        <p class="font-mono text-[12px] uppercase tracking-[0.2em] text-accent">Diagnóstico</p>
        <h2 class="mt-3 text-[28px] font-bold tracking-tight text-white sm:mt-4 sm:text-4xl">
            Qual é a sua dor?
        </h2>
        <p class="mt-4 text-[15px] leading-relaxed text-slate-400 sm:mt-5 sm:text-base">
            Escolha o que mais pesa no seu dia a dia. Eu mostro como costumo resolver
            e você me conta o resto no WhatsApp.
        </p>
    </header>

    <div data-diagnostico data-telefone="{{ $telefone }}" class="mt-10 sm:mt-14">

        {{-- ── Lista de dores ───────────────────────────────────── --}}
        <div class="grid gap-2.5 sm:grid-cols-2 sm:gap-3">
            @foreach ($dores as $i => $dor)
                <button type="button"
                        data-dor
                        data-indice="{{ $i }}"
                        data-titulo="{{ $dor['titulo'] }}"
                        aria-expanded="false"
                        aria-controls="resposta-{{ $i }}"
                        class="group flex items-start gap-3 rounded-xl border border-line bg-panel/50 p-4 text-left
                               transition-all duration-200 sm:gap-3.5 sm:p-5
                               hover:-translate-y-0.5 hover:border-slate-700 hover:bg-panel/80
                               aria-expanded:border-accent/60 aria-expanded:bg-accent/[.07]
                               focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                               focus-visible:outline-accent">

                    <span aria-hidden="true"
                          class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg
                                 border border-line bg-ink/60 font-mono text-[11px] text-slate-500
                                 transition-colors duration-200
                                 group-hover:text-slate-300
                                 group-aria-expanded:border-accent/40 group-aria-expanded:bg-accent/15 group-aria-expanded:text-accent">
                        {{ $i + 1 }}
                    </span>

                    <span class="min-w-0 flex-1">
                        <span class="block text-[14.5px] font-medium leading-snug text-slate-200 sm:text-[15px]">
                            {{ $dor['titulo'] }}
                        </span>
                        @if (!empty($dor['exemplo']))
                            {{-- O exemplo esclarece, mas no celular alonga demais
                                 uma lista de 11 itens. O título já basta para escolher. --}}
                            <span class="mt-1 hidden text-[12.5px] leading-relaxed text-slate-500 sm:mt-1.5 sm:block">
                                {{ $dor['exemplo'] }}
                            </span>
                        @endif
                    </span>
                </button>
            @endforeach
        </div>

        {{--
          Escape para quem não se encaixa em nenhuma das opções acima.
          Borda tracejada e largura total: lê como "nenhuma das anteriores",
          não como mais um item da lista.
        --}}
        <button type="button"
                data-dor
                data-outra
                data-indice="{{ count($dores) }}"
                data-titulo="Tenho uma situação específica"
                aria-expanded="false"
                class="group mt-2.5 flex w-full items-center justify-between gap-4 rounded-xl border border-dashed
                       border-line bg-transparent p-4 text-left transition-all duration-200 sm:mt-3 sm:p-5
                       hover:border-slate-600 hover:bg-panel/40
                       aria-expanded:border-accent/50 aria-expanded:border-solid aria-expanded:bg-accent/[.07]
                       focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                       focus-visible:outline-accent">

            <span class="flex items-start gap-3.5">
                <span aria-hidden="true"
                      class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg
                             border border-dashed border-line font-mono text-[13px] text-slate-500
                             transition-colors duration-200
                             group-hover:text-slate-300
                             group-aria-expanded:border-solid group-aria-expanded:border-accent/40
                             group-aria-expanded:bg-accent/15 group-aria-expanded:text-accent">
                    +
                </span>

                <span class="min-w-0">
                    <span class="block text-[14.5px] font-medium leading-snug text-slate-200 sm:text-[15px]">
                        Nenhuma dessas — tenho uma situação específica
                    </span>
                    <span class="mt-1.5 block text-[12.5px] leading-relaxed text-slate-500">
                        Ou são várias juntas. Me conta o seu caso que eu penso no caminho.
                    </span>
                </span>
            </span>

            <svg class="hidden h-4 w-4 shrink-0 text-slate-600 transition-colors group-hover:text-slate-400 sm:block"
                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
            </svg>
        </button>

        {{-- ── Resposta (revelada ao escolher) ──────────────────── --}}
        <div data-resposta hidden
             class="mt-5 overflow-hidden rounded-2xl border border-line bg-panel/70 backdrop-blur-sm sm:mt-6">

            <div class="flex items-center gap-2 border-b border-line/80 px-6 py-3.5">
                <span class="h-1.5 w-1.5 rounded-full bg-accent" aria-hidden="true"></span>
                <p class="font-mono text-[11px] uppercase tracking-[0.15em] text-slate-500">
                    Como eu costumo resolver
                </p>
            </div>

            <div class="p-5 sm:p-7">
                <p data-resposta-titulo class="text-[17px] font-semibold leading-snug text-white sm:text-lg"></p>

                <ol data-resposta-passos class="mt-5 space-y-3 sm:mt-6 sm:space-y-3.5"></ol>

                <div class="mt-6 flex flex-col gap-4 border-t border-line/70 pt-5 sm:mt-7 sm:flex-row sm:items-center sm:justify-between sm:pt-6">
                    <p data-resposta-prazo class="text-[13.5px] text-slate-400"></p>

                    <a data-whatsapp
                       href="https://wa.me/{{ $telefone }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-accent
                              px-6 py-4 text-[15px] font-semibold text-ink transition-all duration-300 sm:w-auto sm:py-3.5
                              hover:-translate-y-0.5 hover:bg-emerald-300
                              hover:shadow-[0_10px_38px_-10px_rgba(45,212,167,.65)]
                              focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4
                              focus-visible:outline-accent">
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884a9.82 9.82 0 0 1 6.988 2.896 9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885m8.413-18.297A11.82 11.82 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.88 11.88 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.82 11.82 0 0 0 20.465 3.49"/>
                        </svg>
                        Contar meu caso
                    </a>
                </div>
            </div>
        </div>

        {{-- Dados das respostas: lidos pelo JS, sem requisição extra. --}}
        @php
            $respostas = array_map(static fn ($d) => [
                'titulo' => $d['titulo'],
                'resumo' => $d['resumo'],
                'passos' => $d['passos'],
                'prazo'  => 'Projetos assim costumam levar ' . $d['prazo'] . '.',
                'mensagem' => "Olá! Vim pelo seu site.

Minha situação hoje: " . $d['titulo'] . "

Gostaria de conversar sobre como resolver isso.",
            ], $dores);

            // Última entrada: o "nenhuma dessas". Fica no componente porque
            // o texto é o mesmo em qualquer lista de dores.
            $respostas[] = [
                'titulo' => 'Tenho uma situação específica',
                'resumo' => 'Todo projeto começa com uma conversa',
                'passos' => [
                    'Você me conta o que está acontecendo, com as suas palavras.',
                    'Eu faço as perguntas que faltam para entender o tamanho real.',
                    'Volto com um caminho técnico e uma estimativa — sem compromisso.',
                ],
                'prazo'  => 'O prazo depende do que a gente descobrir na conversa.',
                'mensagem' => "Olá! Vim pelo seu site.

Minha situação não estava na lista — queria te contar o meu caso:

",
            ];
        @endphp

        <script type="application/json" data-diagnostico-dados>{!! json_encode($respostas, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    </div>
</section>
