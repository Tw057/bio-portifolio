<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfiguracaoController extends Controller
{
    public function edit(): View
    {
        return view('admin.configuracoes', [
            'config' => Configuracao::todas(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome'              => ['required', 'string', 'max:60'],
            'cargo'             => ['required', 'string', 'max:80'],
            'whatsapp'          => ['required', 'string', 'max:20'],
            'whatsapp_mensagem' => ['nullable', 'string', 'max:300'],
            'email'             => ['required', 'email', 'max:120'],
            'github'            => ['nullable', 'url', 'max:255'],
            'instagram'         => ['nullable', 'url', 'max:255'],
            'linkedin'          => ['nullable', 'url', 'max:255'],
            'twitter'           => ['nullable', 'url', 'max:255'],
            'local'             => ['nullable', 'string', 'max:80'],
        ], [
            'whatsapp.required' => 'O WhatsApp é o principal canal do site.',
            'email.email'       => 'Informe um e-mail válido.',
            '*.url'             => 'Use a URL completa, começando com https://',
        ]);

        // Só dígitos: o wa.me não aceita parênteses, traço ou espaço.
        $dados['whatsapp'] = preg_replace('/\D/', '', $dados['whatsapp']);

        Configuracao::gravar($dados);

        return back()->with('sucesso', 'Dados atualizados.');
    }
}
