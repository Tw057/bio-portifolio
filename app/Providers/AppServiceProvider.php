<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->garantirUrlCorreta();
    }

    /**
     * Garante que route() e asset() gerem links com o domínio real.
     *
     * Sem APP_URL definida, o Laravel usa "http://localhost" como base, e
     * todo link gerado por route() aponta para a máquina de quem está
     * navegando. O dono do site não percebe — ele tem um servidor local
     * rodando — mas para qualquer visitante os botões simplesmente falham.
     *
     * Em produção, forçamos HTTPS e adotamos o host que o próprio navegador
     * usou para chegar aqui, o que torna o site imune a uma APP_URL ausente
     * ou desatualizada.
     */
    private function garantirUrlCorreta(): void
    {
        if (! $this->app->environment('production')) {
            return;
        }

        // O Render termina o TLS num proxy: a conexão interna é http, mas o
        // visitante acessou por https. Sem isso, os links sairiam em http e
        // o navegador bloquearia o conteúdo misto.
        URL::forceScheme('https');

        $request = $this->app['request'];

        if ($host = $request->getHost()) {
            URL::forceRootUrl('https://' . $host);
        }
    }
}
