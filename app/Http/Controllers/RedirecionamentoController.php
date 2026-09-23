<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Evento;
use App\Services\Rastreador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * /go/{destino} — registra o clique e redireciona.
 *
 * Por que existe: um link que aponta direto para o WhatsApp sai do seu
 * servidor sem deixar rastro. Passando por aqui, o clique é contado —
 * e sem depender de JavaScript, então funciona até com bloqueador de anúncio.
 */
class RedirecionamentoController extends Controller
{
    public function __invoke(Request $request, string $destino, Rastreador $rastreador): RedirectResponse
    {
        // Só destinos da lista fixa. Nunca redirecionamos para uma URL
        // que veio do usuário — seria um open redirect.
        if (! in_array($destino, Rastreador::DESTINOS, true)) {
            throw new NotFoundHttpException();
        }

        $url = $this->urlDe($destino);

        if (! $url) {
            throw new NotFoundHttpException();
        }

        $rastreador->registrar($request, Evento::TIPO_CLIQUE, $destino);

        // away() porque o destino é externo; o Laravel não valida host aqui,
        // mas a lista acima já garantiu que a URL é nossa.
        return redirect()->away($url, 302);
    }

    private function urlDe(string $destino): ?string
    {
        $config = Configuracao::todas();

        return match ($destino) {
            'whatsapp'  => $this->whatsapp($config),
            'email'     => ($e = $config['email'] ?? null) ? 'mailto:' . $e : null,
            'github', 'instagram', 'linkedin', 'twitter' => $config[$destino] ?? null,
            default     => null,
        };
    }

    private function whatsapp(array $config): ?string
    {
        $numero = preg_replace('/\D/', '', $config['whatsapp'] ?? '');

        if (! $numero) {
            return null;
        }

        $texto = $config['whatsapp_mensagem']
            ?? 'Olá! Vim pelo seu site e gostaria de conversar sobre um projeto.';

        return 'https://wa.me/' . $numero . '?text=' . rawurlencode($texto);
    }
}
