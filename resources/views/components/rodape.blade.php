@props([
    'nome'      => 'Thiago',
    'cargo'     => 'Desenvolvedor de Software · PHP / Laravel',
    'email'     => '',
    'emailUrl'  => null,   // link rastreado; cai no mailto se ausente
    'whatsapp'  => '#',    // já vem como URL pronta
    'github'    => null,
    'linkedin'  => null,
    'instagram' => null,
    'twitter'   => null,
    'local'     => 'Brasil · Atendimento remoto',
])

@php
    $linkEmail = $emailUrl ?: 'mailto:' . $email;
@endphp

<footer class="relative border-t border-line/70 bg-panel/20">
    <div class="mx-auto max-w-6xl px-5 py-12 sm:px-6 sm:py-16 lg:px-8">

        {{-- ── Chamada final ────────────────────────────────────── --}}
        <div class="flex flex-col gap-7 border-b border-line/60 pb-10 sm:gap-8 sm:pb-12 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-lg">
                <h2 class="text-[26px] font-bold tracking-tight text-white sm:text-3xl">
                    Vamos conversar sobre o seu projeto?
                </h2>
                <p class="mt-3.5 text-[14.5px] leading-relaxed text-slate-400 sm:mt-4 sm:text-[15px]">
                    Me conta o que está travando o seu dia a dia. Respondo com um caminho
                    técnico e uma estimativa — sem compromisso.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row lg:shrink-0">
                <a href="{{ $whatsapp }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3.5
                          text-[15px] font-semibold text-ink transition-all duration-300
                          hover:-translate-y-0.5 hover:bg-emerald-300
                          hover:shadow-[0_10px_38px_-10px_rgba(45,212,167,.65)]
                          focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4
                          focus-visible:outline-accent">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884a9.82 9.82 0 0 1 6.988 2.896 9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885m8.413-18.297A11.82 11.82 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.88 11.88 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.82 11.82 0 0 0 20.465 3.49"/>
                    </svg>
                    Chamar no WhatsApp
                </a>

                <a href="{{ $linkEmail }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-line
                          bg-panel/50 px-6 py-3.5 text-[15px] font-medium text-slate-300
                          transition-colors duration-300 hover:border-slate-600 hover:text-white
                          focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4
                          focus-visible:outline-slate-500">
                    <svg class="h-[18px] w-[18px] text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M3 4a2 2 0 0 0-2 2v.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 6.161V6a2 2 0 0 0-2-2H3Z"/>
                        <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z"/>
                    </svg>
                    Enviar e-mail
                </a>
            </div>
        </div>

        {{-- ── Navegação e contato ──────────────────────────────── --}}
        <div class="grid gap-8 py-10 sm:grid-cols-2 sm:gap-10 sm:py-12 lg:grid-cols-4">

            <div class="sm:col-span-2 lg:col-span-1">
                <p class="text-[15px] font-semibold text-white">{{ $nome }}</p>
                <p class="mt-2 font-mono text-[13px] text-slate-500">{{ $cargo }}</p>
                <p class="mt-4 max-w-xs text-[13.5px] leading-relaxed text-slate-500">
                    Sistemas web sob medida para empresas e autônomos.
                </p>
            </div>

            <nav aria-label="Seções do site">
                <p class="font-mono text-[11px] uppercase tracking-[0.15em] text-slate-600">Navegar</p>
                <ul class="mt-3 -ml-2 space-y-0.5 sm:mt-4">
                    @foreach ([
                        ['rotulo' => 'Como eu resolvo', 'href' => '#diagnostico'],
                        ['rotulo' => 'Projetos',        'href' => '#projetos'],
                        ['rotulo' => 'Início',          'href' => '#conteudo'],
                    ] as $link)
                        <li>
                            <a href="{{ $link['href'] }}"
                               class="inline-flex min-h-[44px] items-center px-2 text-[14px] text-slate-400 transition-colors hover:text-accent
                                      focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                      focus-visible:outline-accent">
                                {{ $link['rotulo'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div>
                <p class="font-mono text-[11px] uppercase tracking-[0.15em] text-slate-600">Contato</p>
                <ul class="mt-3 -ml-2 space-y-0.5 sm:mt-4">
                    <li>
                        <a href="{{ $linkEmail }}"
                           class="inline-flex min-h-[44px] items-center break-all px-2 text-[14px] text-slate-400 transition-colors hover:text-accent
                                  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                  focus-visible:outline-accent">
                            {{ $email }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex min-h-[44px] items-center px-2 text-[14px] text-slate-400 transition-colors hover:text-accent
                                  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                  focus-visible:outline-accent">
                            WhatsApp
                        </a>
                    </li>
                    <li class="px-2 pt-1 text-[13.5px] text-slate-500">{{ $local }}</li>
                </ul>
            </div>

            <div>
                <p class="font-mono text-[11px] uppercase tracking-[0.15em] text-slate-600">Redes</p>
                @php
                    $redes = [
                        ['nome' => 'GitHub',    'url' => $github,    'path' => 'M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2Z'],
                        ['nome' => 'LinkedIn',  'url' => $linkedin,  'path' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286ZM5.337 7.433a2.062 2.062 0 1 1 0-4.125 2.062 2.062 0 0 1 0 4.125Zm1.782 13.019H3.555V9h3.564v11.452ZM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003Z'],
                        ['nome' => 'Instagram', 'url' => $instagram, 'path' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z'],
                        ['nome' => 'Twitter',   'url' => $twitter,   'path' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z'],
                    ];
                @endphp
                <div class="mt-3 -ml-2.5 flex flex-wrap gap-0.5 sm:mt-4">
                    @foreach ($redes as $rede)
                        @continue(! $rede['url'])
                        <a href="{{ $rede['url'] }}" target="_blank" rel="noopener noreferrer"
                           aria-label="{{ $rede['nome'] }}"
                           class="flex h-11 w-11 items-center justify-center rounded-lg text-slate-500 transition-colors duration-200
                                  hover:bg-panel hover:text-accent
                                  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                  focus-visible:outline-accent">
                            <svg class="h-[17px] w-[17px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="{{ $rede['path'] }}"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Linha final ──────────────────────────────────────── --}}
        <div class="flex flex-col items-center gap-3 border-t border-line/60 pt-8 sm:flex-row sm:justify-between">
            <p class="text-[12.5px] text-slate-600">
                © {{ date('Y') }} {{ $nome }}. Todos os direitos reservados.
            </p>
            <p class="font-mono text-[11.5px] text-slate-700">
                Feito com Laravel &amp; Tailwind
            </p>
        </div>
    </div>

    {{-- respiro para a barra fixa não cobrir o conteúdo no mobile --}}
    <div aria-hidden="true" class="h-24 lg:hidden"></div>
</footer>
