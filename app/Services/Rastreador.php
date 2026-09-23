<?php

namespace App\Services;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Registra visitas e cliques sem identificar ninguém.
 *
 * Decisões que valem revisão:
 *
 * 1. LGPD — o IP é dado pessoal. Guardamos apenas um hash com o APP_KEY
 *    como salt, o que permite contar visitantes distintos sem saber quem são.
 *    O hash não é reversível e não sai desta aplicação.
 *
 * 2. Bots — metade do tráfego da web é robô. Sem filtrar, o contador vira
 *    ficção. Marcamos como 'bot' em vez de descartar, para dar para auditar.
 *
 * 3. Falha silenciosa — analytics nunca pode derrubar a página. Qualquer erro
 *    aqui vira log, não exceção para o visitante.
 *
 * 4. Dono do site — quem administra visita o próprio site o tempo todo para
 *    conferir. Sem excluir esses acessos, a métrica mede o próprio dono.
 */
class Rastreador
{
    /** Cookie que marca o navegador do dono. Gravado ao entrar no painel. */
    public const COOKIE_DONO = 'sou_o_dono';

    /**
     * Destinos válidos para /go/{destino}.
     *
     * Esta lista é a defesa contra open redirect: sem ela, alguém poderia
     * usar seu domínio para redirecionar a um site de golpe
     * (seusite.com/go?url=golpe.com) emprestando a sua credibilidade.
     * O parâmetro da URL é só uma CHAVE — o destino real nunca vem do usuário.
     */
    public const DESTINOS = [
        'whatsapp',
        'github',
        'instagram',
        'linkedin',
        'twitter',
        'email',
        'demo',
        'repo',
    ];

    public function registrar(Request $request, string $tipo, ?string $destino = null): void
    {
        if ($this->ehODono($request)) {
            return;
        }

        try {
            $agente = (string) $request->userAgent();

            Evento::create([
                'tipo'           => $tipo,
                'destino'        => $destino,
                'referrer'       => $this->origem($request),
                'dispositivo'    => $this->dispositivo($agente),
                'visitante_hash' => $this->hashVisitante($request, $agente),
            ]);
        } catch (\Throwable $e) {
            // Medição não pode quebrar a experiência de quem está navegando.
            Log::warning('Falha ao registrar evento', ['erro' => $e->getMessage()]);
        }
    }

    /**
     * O acesso é do dono do site?
     *
     * Duas checagens, porque cobrem situações diferentes:
     * - sessão ativa: você está logado no painel agora;
     * - cookie: você já entrou alguma vez neste navegador, mesmo deslogado.
     *
     * O cookie é o que realmente resolve — você confere o site muito mais
     * vezes deslogado do que logado.
     */
    public function ehODono(Request $request): bool
    {
        if (auth()->hasUser() && auth()->check()) {
            return true;
        }

        return $request->cookie(self::COOKIE_DONO) === $this->assinaturaDono();
    }

    /**
     * Valor do cookie: um hash derivado do APP_KEY.
     *
     * Não é um valor fixo como "1" porque qualquer pessoa poderia gravá-lo
     * no próprio navegador e sumir das estatísticas. Derivar do APP_KEY
     * significa que só o servidor sabe produzir o valor aceito.
     */
    public function assinaturaDono(): string
    {
        return substr(hash_hmac('sha256', 'dono-do-site', config('app.key')), 0, 32);
    }

    /** Só o host de origem — a URL completa poderia conter dados de busca. */
    private function origem(Request $request): ?string
    {
        $referrer = $request->headers->get('referer');

        if (! $referrer) {
            return null;
        }

        $host = parse_url($referrer, PHP_URL_HOST);

        // Navegação interna não conta como origem externa.
        if (! $host || $host === $request->getHost()) {
            return null;
        }

        return substr($host, 0, 255);
    }

    private function dispositivo(string $agente): string
    {
        if ($agente === '') {
            return 'bot';
        }

        $ehBot = preg_match(
            '/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|preview|monitor|curl|wget|headless|python|axios/i',
            $agente
        );

        if ($ehBot) {
            return 'bot';
        }

        return preg_match('/mobile|android|iphone|ipad|ipod/i', $agente)
            ? 'mobile'
            : 'desktop';
    }

    /**
     * Identificador anônimo e rotativo.
     *
     * O sal inclui a data: o mesmo visitante gera hashes diferentes a cada dia,
     * o que impede montar um histórico de longo prazo de uma pessoa —
     * mas ainda permite contar visitantes únicos dentro do dia.
     */
    private function hashVisitante(Request $request, string $agente): string
    {
        return hash('sha256', implode('|', [
            $request->ip(),
            $agente,
            now()->toDateString(),
            config('app.key'),
        ]));
    }
}
