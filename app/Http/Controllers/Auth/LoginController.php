<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Rastreador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function mostrar(): View
    {
        return view('auth.login');
    }

    public function entrar(Request $request, Rastreador $rastreador): RedirectResponse
    {
        $credenciais = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // throttle na rota limita tentativas; aqui a mensagem é genérica
        // de propósito: dizer "e-mail não existe" entrega quais contas existem.
        if (! Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas.',
            ]);
        }

        // Troca o ID da sessão após autenticar — defesa contra session fixation.
        $request->session()->regenerate();

        // Marca este navegador como "do dono": a partir daqui suas visitas
        // e cliques não entram nas métricas, mesmo depois de sair do painel.
        // 1 ano, httpOnly, e o valor é derivado do APP_KEY (ver Rastreador).
        Cookie::queue(Cookie::make(
            Rastreador::COOKIE_DONO,
            $rastreador->assinaturaDono(),
            60 * 24 * 365,
            httpOnly: true,
        ));

        return redirect()->intended(route('admin.painel'));
    }

    public function sair(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // O cookie do dono NÃO é apagado aqui de propósito: você continua
        // fora das métricas ao navegar deslogado, que é a maior parte do tempo.

        return redirect()->route('home');
    }
}
