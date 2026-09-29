# Portfólio — Thiago

Bio site que funciona como porta de entrada: quem chega pelo Instagram encontra
a própria dor descrita em uma lista, vê como ela costuma ser resolvida e sai
com uma conversa iniciada no WhatsApp.

Tem painel administrativo próprio, métricas de acesso sem serviço de terceiros
e nenhum dado escrito no código — tudo vem do banco.

## O que tem

**Site público**
- Hero com apresentação e chamada principal
- Diagnóstico: 11 dores comuns, cada uma com o caminho de solução e uma
  mensagem de WhatsApp já redigida
- Projetos com stack, links de código e demo
- Barra de conversão que surge ao rolar

**Painel** (`/painel`)
- Visitas, visitantes distintos e cliques dos últimos 30 dias
- CRUD de projetos com ordenação e rascunho
- Edição dos dados de contato

**Métricas próprias**
Links externos passam por `/go/{destino}`, que registra o clique e redireciona.
Funciona sem JavaScript, então conta mesmo com bloqueador de anúncio ativo.

## Stack

PHP 8.3 · Laravel 13 · PostgreSQL · Tailwind 4 · Vite · Docker

Sem bibliotecas de front: as interações são ~10 KB de JavaScript escrito à mão,
e a página inteira funciona se o script falhar.

## Decisões que valem explicação

**Open redirect bloqueado.** `/go/{destino}` aceita apenas chaves de uma lista
fixa no servidor. Sem isso, qualquer um poderia usar o domínio para redirecionar
a um site de golpe, emprestando a credibilidade dele.

**LGPD nas métricas.** IP é dado pessoal, então guardamos só um hash com salt
que inclui a data — dá para contar visitantes únicos no dia, não para montar o
histórico de uma pessoa.

**Robôs fora da conta.** Metade do tráfego da web é automatizado. Sem filtrar,
o número mente.

**O dono não se mede.** Ao entrar no painel, o navegador recebe um cookie
derivado do `APP_KEY`. A partir daí as visitas do administrador não entram nas
estatísticas, mesmo deslogado.

## Rodando localmente

```bash
composer install
npm install && npm run build
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan admin:criar --email=voce@exemplo.com
php artisan serve
```

Site em `http://localhost:8000`, painel em `/painel`.

## Publicando

Veja [DEPLOY.md](DEPLOY.md) — o `render.yaml` configura serviço e banco
automaticamente a partir do repositório.
