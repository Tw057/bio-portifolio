@extends('admin.layout')

@php $novo = ! $projeto->exists; @endphp

@section('titulo', $novo ? 'Novo projeto' : 'Editar projeto')

@section('conteudo')

    <header class="mb-8">
        <a href="{{ route('admin.projetos.index') }}"
           class="text-[13px] text-slate-500 transition-colors hover:text-accent">← Projetos</a>
        <h1 class="mt-3 text-2xl font-bold tracking-tight text-white">
            {{ $novo ? 'Novo projeto' : 'Editar projeto' }}
        </h1>
    </header>

    <form method="POST"
          action="{{ $novo ? route('admin.projetos.store') : route('admin.projetos.update', $projeto) }}"
          class="max-w-2xl space-y-6">
        @csrf
        @unless ($novo) @method('PUT') @endunless

        @php
            $classeCampo = 'mt-2 w-full rounded-lg border border-line bg-ink px-3.5 py-2.5 text-[14.5px] text-white
                            placeholder-slate-600 transition-colors
                            focus:border-accent/50 focus:outline-none focus:ring-1 focus:ring-accent/40';
        @endphp

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <label for="titulo" class="block text-[13px] font-medium text-slate-400">
                Título <span class="text-red-400">*</span>
            </label>
            <input type="text" name="titulo" id="titulo" required maxlength="120"
                   value="{{ old('titulo', $projeto->titulo) }}"
                   placeholder="Sistema de Gestão para Clínica Veterinária"
                   class="{{ $classeCampo }}">

            <label for="descricao" class="mt-6 block text-[13px] font-medium text-slate-400">
                Descrição <span class="text-red-400">*</span>
            </label>
            <textarea name="descricao" id="descricao" rows="4" required maxlength="600"
                      placeholder="O que o sistema resolve, em linguagem de cliente."
                      class="{{ $classeCampo }} resize-y">{{ old('descricao', $projeto->descricao) }}</textarea>
            <p class="mt-2 text-[12px] text-slate-600">
                Fale do problema resolvido, não das tecnologias — a stack tem campo próprio.
            </p>
        </div>

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <label for="stack" class="block text-[13px] font-medium text-slate-400">Stack</label>
            <input type="text" name="stack" id="stack"
                   value="{{ old('stack', is_array($projeto->stack) ? implode(', ', $projeto->stack) : '') }}"
                   placeholder="Laravel, PostgreSQL, Docker"
                   class="{{ $classeCampo }} font-mono text-[13.5px]">
            <p class="mt-2 text-[12px] text-slate-600">Separe por vírgula. Máximo 10.</p>

            <label for="metricas" class="mt-6 block text-[13px] font-medium text-slate-400">Métricas</label>
            <input type="text" name="metricas" id="metricas"
                   value="{{ old('metricas', is_array($projeto->metricas) ? implode(', ', $projeto->metricas) : '') }}"
                   placeholder="4 entidades, MVC próprio, No ar via Render"
                   class="{{ $classeCampo }} font-mono text-[13.5px]">
            <p class="mt-2 text-[12px] text-slate-600">
                Números verdadeiros. Máximo 6, separadas por vírgula.
            </p>
        </div>

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <label for="repo" class="block text-[13px] font-medium text-slate-400">Link do repositório</label>
            <input type="url" name="repo" id="repo"
                   value="{{ old('repo', $projeto->repo) }}"
                   placeholder="https://github.com/usuario/projeto"
                   class="{{ $classeCampo }}">

            <label for="demo" class="mt-6 block text-[13px] font-medium text-slate-400">Link da demo</label>
            <input type="url" name="demo" id="demo"
                   value="{{ old('demo', $projeto->demo) }}"
                   placeholder="https://meu-projeto.onrender.com"
                   class="{{ $classeCampo }}">

            <label class="mt-6 flex cursor-pointer items-start gap-3">
                <input type="checkbox" name="demo_aberta" value="1"
                       @checked(old('demo_aberta', $projeto->demo_aberta))
                       class="mt-0.5 h-4 w-4 rounded border-line bg-ink text-accent focus:ring-1 focus:ring-accent/40">
                <span>
                    <span class="block text-[14px] text-slate-300">Demo aberta para testar</span>
                    <span class="mt-0.5 block text-[12px] text-slate-600">
                        Mostra o selo "pode entrar e mexer" e muda o botão para "Testar o sistema".
                    </span>
                </span>
            </label>
        </div>

        <div class="rounded-xl border border-line bg-panel/50 p-6">
            <label class="flex cursor-pointer items-start gap-3">
                <input type="checkbox" name="publicado" value="1"
                       @checked(old('publicado', $projeto->publicado))
                       class="mt-0.5 h-4 w-4 rounded border-line bg-ink text-accent focus:ring-1 focus:ring-accent/40">
                <span>
                    <span class="block text-[14px] text-slate-300">Publicado no site</span>
                    <span class="mt-0.5 block text-[12px] text-slate-600">
                        Desmarque para deixar como rascunho enquanto escreve.
                    </span>
                </span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="rounded-lg bg-accent px-5 py-2.5 text-[14.5px] font-semibold text-ink
                           transition-colors hover:bg-emerald-300
                           focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent">
                {{ $novo ? 'Criar projeto' : 'Salvar alterações' }}
            </button>

            <a href="{{ route('admin.projetos.index') }}"
               class="rounded-lg border border-line px-5 py-2.5 text-[14.5px] text-slate-400
                      transition-colors hover:border-slate-600 hover:text-white">
                Cancelar
            </a>
        </div>
    </form>

@endsection
