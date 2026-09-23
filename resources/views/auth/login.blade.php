<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Entrar · Painel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-ink px-6 font-sans text-slate-300 antialiased">

    <div aria-hidden="true"
         class="pointer-events-none fixed left-1/2 top-0 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full
                bg-[radial-gradient(circle,rgba(45,212,167,.10),transparent_65%)] blur-3xl"></div>

    <main class="relative w-full max-w-sm">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold tracking-tight text-white">Painel</h1>
            <p class="mt-2 text-[13.5px] text-slate-500">Acesso restrito</p>
        </div>

        <form method="POST" action="{{ route('login') }}"
              class="rounded-2xl border border-line bg-panel/60 p-7 backdrop-blur-sm">
            @csrf

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-lg border border-red-500/30 bg-red-500/10 px-3.5 py-2.5">
                    <p class="text-[13.5px] text-red-300">{{ $errors->first() }}</p>
                </div>
            @endif

            <label for="email" class="block text-[13px] font-medium text-slate-400">E-mail</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="mt-2 w-full rounded-lg border border-line bg-ink px-3.5 py-2.5 text-[14.5px] text-white
                          placeholder-slate-600 transition-colors
                          focus:border-accent/50 focus:outline-none focus:ring-1 focus:ring-accent/40">

            <label for="password" class="mt-5 block text-[13px] font-medium text-slate-400">Senha</label>
            <input type="password" name="password" id="password"
                   required autocomplete="current-password"
                   class="mt-2 w-full rounded-lg border border-line bg-ink px-3.5 py-2.5 text-[14.5px] text-white
                          transition-colors
                          focus:border-accent/50 focus:outline-none focus:ring-1 focus:ring-accent/40">

            <label class="mt-5 flex cursor-pointer items-center gap-2.5">
                <input type="checkbox" name="lembrar" value="1"
                       class="h-4 w-4 rounded border-line bg-ink text-accent focus:ring-1 focus:ring-accent/40">
                <span class="text-[13.5px] text-slate-400">Manter conectado</span>
            </label>

            <button type="submit"
                    class="mt-7 w-full rounded-lg bg-accent px-5 py-3 text-[14.5px] font-semibold text-ink
                           transition-colors hover:bg-emerald-300
                           focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                           focus-visible:outline-accent">
                Entrar
            </button>
        </form>

        <p class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-[13px] text-slate-600 transition-colors hover:text-slate-400">
                ← Voltar ao site
            </a>
        </p>
    </main>

</body>
</html>
