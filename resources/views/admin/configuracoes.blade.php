@extends('admin.layout')

@section('titulo', 'Contato')

@section('conteudo')

    <header class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-white">Contato e identidade</h1>
        <p class="mt-1.5 text-[14px] text-slate-500">
            Estes dados aparecem no site inteiro — Hero, rodapé e botões de WhatsApp.
        </p>
    </header>

    <form method="POST" action="{{ route('admin.configuracoes.update') }}" class="max-w-2xl space-y-6">
        @csrf
        @method('PUT')

        @php
            $classeCampo = 'mt-2 w-full rounded-lg border border-line bg-ink px-3.5 py-2.5 text-[14.5px] text-white
                            placeholder-slate-600 transition-colors
                            focus:border-accent/50 focus:outline-none focus:ring-1 focus:ring-accent/40';
        @endphp

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <h2 class="text-[15px] font-semibold text-white">Identidade</h2>

            <label for="nome" class="mt-5 block text-[13px] font-medium text-slate-400">
                Nome <span class="text-red-400">*</span>
            </label>
            <input type="text" name="nome" id="nome" required maxlength="60"
                   value="{{ old('nome', $config['nome'] ?? '') }}"
                   class="{{ $classeCampo }}">

            <label for="cargo" class="mt-5 block text-[13px] font-medium text-slate-400">
                Cargo <span class="text-red-400">*</span>
            </label>
            <input type="text" name="cargo" id="cargo" required maxlength="80"
                   value="{{ old('cargo', $config['cargo'] ?? '') }}"
                   placeholder="Desenvolvedor de Software · PHP / Laravel"
                   class="{{ $classeCampo }}">

            <label for="local" class="mt-5 block text-[13px] font-medium text-slate-400">Localização</label>
            <input type="text" name="local" id="local" maxlength="80"
                   value="{{ old('local', $config['local'] ?? '') }}"
                   placeholder="Brasil · Atendimento remoto"
                   class="{{ $classeCampo }}">
        </div>

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <h2 class="text-[15px] font-semibold text-white">Canais</h2>

            <label for="whatsapp" class="mt-5 block text-[13px] font-medium text-slate-400">
                WhatsApp <span class="text-red-400">*</span>
            </label>
            <input type="text" name="whatsapp" id="whatsapp" required maxlength="20"
                   value="{{ old('whatsapp', $config['whatsapp'] ?? '') }}"
                   placeholder="5511987654321"
                   class="{{ $classeCampo }} font-mono">
            <p class="mt-2 text-[12px] text-slate-600">
                Código do país + DDD + número, só dígitos. Ex.: 55 11 98765-4321 → 5511987654321
            </p>

            <label for="whatsapp_mensagem" class="mt-5 block text-[13px] font-medium text-slate-400">
                Mensagem inicial do WhatsApp
            </label>
            <textarea name="whatsapp_mensagem" id="whatsapp_mensagem" rows="2" maxlength="300"
                      class="{{ $classeCampo }} resize-y">{{ old('whatsapp_mensagem', $config['whatsapp_mensagem'] ?? '') }}</textarea>
            <p class="mt-2 text-[12px] text-slate-600">
                Já vem digitada quando a pessoa abre a conversa.
            </p>

            <label for="email" class="mt-5 block text-[13px] font-medium text-slate-400">
                E-mail <span class="text-red-400">*</span>
            </label>
            <input type="email" name="email" id="email" required maxlength="120"
                   value="{{ old('email', $config['email'] ?? '') }}"
                   class="{{ $classeCampo }}">
        </div>

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <h2 class="text-[15px] font-semibold text-white">Redes sociais</h2>
            <p class="mt-1.5 text-[12.5px] text-slate-600">
                Deixe em branco para esconder o ícone.
            </p>

            @foreach ([
                'github'    => 'https://github.com/usuario',
                'linkedin'  => 'https://linkedin.com/in/usuario',
                'instagram' => 'https://instagram.com/usuario',
                'twitter'   => 'https://x.com/usuario',
            ] as $campo => $exemplo)
                <label for="{{ $campo }}" class="mt-5 block text-[13px] font-medium capitalize text-slate-400">
                    {{ $campo }}
                </label>
                <input type="url" name="{{ $campo }}" id="{{ $campo }}" maxlength="255"
                       value="{{ old($campo, $config[$campo] ?? '') }}"
                       placeholder="{{ $exemplo }}"
                       class="{{ $classeCampo }}">
            @endforeach
        </div>

        <button type="submit"
                class="rounded-lg bg-accent px-5 py-2.5 text-[14.5px] font-semibold text-ink
                       transition-colors hover:bg-emerald-300
                       focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent">
            Salvar
        </button>
    </form>

@endsection
