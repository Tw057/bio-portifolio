<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Thiago — Desenvolvedor de Software | Sistemas, Sites e Lojas')</title>
    <meta name="description" content="@yield('description', 'Desenvolvedor de software especializado em PHP/Laravel. Crio sistemas, sites e lojas virtuais sob medida para empresas e autônomos.')">

    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph: o cartão que aparece ao colar o link no Instagram,
         WhatsApp, LinkedIn. Sem isso, só a URL crua é exibida. --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="@yield('og_nome', 'Thiago — Desenvolvedor de Software')">
    <meta property="og:title" content="@yield('title', 'Thiago — Desenvolvedor de Software | Sistemas, Sites e Lojas')">
    <meta property="og:description" content="@yield('description', 'Resolvo dores de negócio através de software. Sistemas, sites e lojas sob medida — do banco de dados à tela.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/og.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Software que resolve problemas reais — sistemas, sites e lojas sob medida">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Thiago — Desenvolvedor de Software')">
    <meta name="twitter:description" content="@yield('description', 'Resolvo dores de negócio através de software.')">
    <meta name="twitter:image" content="{{ asset('img/og.png') }}">

    <meta name="theme-color" content="#08090C">
    <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- CSS compilado pelo Vite: ~14 KB em vez dos ~400 KB do CDN,
         e sem processar nada no navegador do visitante. --}}
    @vite(['resources/css/app.css'])
</head>
<body class="bg-ink text-slate-300 font-sans antialiased selection:bg-accent">

    <a href="#conteudo"
       class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:top-4 focus:left-4 focus:rounded-lg focus:bg-accent focus:px-4 focus:py-2 focus:font-semibold focus:text-ink">
        Pular para o conteúdo
    </a>

    <main id="conteudo">
        @yield('content')
    </main>

    {{-- defer: não bloqueia a renderização; a página funciona sem o script --}}
    <script src="{{ asset('js/interacoes.js') }}" defer></script>

</body>
</html>
