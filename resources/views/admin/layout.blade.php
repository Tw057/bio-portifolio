<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('titulo', 'Painel') · Portfólio</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-ink font-sans text-slate-300 antialiased">

    <header class="border-b border-line bg-panel/40">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-6 py-4">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.painel') }}" class="text-[15px] font-semibold text-white">
                    Painel
                </a>

                <nav class="flex items-center gap-1">
                    @foreach ([
                        ['rotulo' => 'Visão geral', 'rota' => 'admin.painel'],
                        ['rotulo' => 'Projetos',    'rota' => 'admin.projetos.index'],
                        ['rotulo' => 'Contato',     'rota' => 'admin.configuracoes.edit'],
                    ] as $item)
                        @php $ativo = request()->routeIs($item['rota']) || request()->routeIs(str_replace('.index', '.*', $item['rota'])); @endphp
                        <a href="{{ route($item['rota']) }}"
                           @if ($ativo) aria-current="page" @endif
                           class="rounded-lg px-3 py-1.5 text-[13.5px] transition-colors
                                  {{ $ativo ? 'bg-accent/10 text-accent' : 'text-slate-400 hover:bg-panel hover:text-white' }}">
                            {{ $item['rotulo'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" rel="noopener"
                   class="hidden text-[13px] text-slate-500 transition-colors hover:text-accent sm:block">
                    Ver o site ↗
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-lg border border-line px-3 py-1.5 text-[13px] text-slate-400
                                   transition-colors hover:border-slate-600 hover:text-white">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">

        @if (session('sucesso'))
            <div role="status"
                 class="mb-6 flex items-center gap-2.5 rounded-xl border border-accent/30 bg-accent/10 px-4 py-3">
                <svg class="h-4 w-4 shrink-0 text-accent" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                </svg>
                <span class="text-[14px] text-accent">{{ session('sucesso') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div role="alert"
                 class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3">
                <p class="text-[14px] font-medium text-red-300">Corrija os campos abaixo:</p>
                <ul class="mt-2 space-y-1">
                    @foreach ($errors->all() as $erro)
                        <li class="text-[13.5px] text-red-300/90">• {{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('conteudo')
    </main>

</body>
</html>
