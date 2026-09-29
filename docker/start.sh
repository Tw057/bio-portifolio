#!/bin/sh
set -e

echo "==> Preparando a aplicação"

# APP_KEY: sem ela o Laravel não sobe. Em produção vem da variável
# de ambiente; aqui é só uma rede de segurança para o primeiro deploy.
if [ -z "$APP_KEY" ]; then
    echo ""
    echo "########################################################"
    echo "#  APP_KEY não definida — gerando uma agora."
    echo "#"
    echo "#  IMPORTANTE: copie a chave abaixo e cole em"
    echo "#  Environment > APP_KEY no painel do Render."
    echo "#  Sem isso, cada reinício gera outra chave e derruba"
    echo "#  as sessões — você é deslogado do painel toda hora."
    echo "########################################################"
    php artisan key:generate --force --show
    php artisan key:generate --force
    echo "########################################################"
    echo ""
fi

# O Postgres do Render pode levar alguns segundos para aceitar conexões
# depois que o container sobe. Sem esperar, a migration falha e o deploy
# inteiro morre por um problema que se resolve sozinho em 10 segundos.
echo "==> Aguardando o banco responder"
tentativa=1
until php artisan db:show --quiet >/dev/null 2>&1; do
    if [ "$tentativa" -ge 20 ]; then
        echo "!! Banco não respondeu após 20 tentativas."
        echo "!! Verifique se DB_URL está definida nas variáveis de ambiente."
        php artisan db:show || true
        exit 1
    fi
    echo "   tentativa $tentativa/20..."
    tentativa=$((tentativa + 1))
    sleep 3
done
echo "==> Banco respondeu"

# --force porque o Laravel pede confirmação em produção.
echo "==> Migrando o banco"
php artisan migrate --force

# Popula na primeira vez. updateOrCreate torna a repetição inofensiva.
echo "==> Semeando dados iniciais"
php artisan db:seed --class=PortfolioSeeder --force || true

# Cria o admin se as variáveis estiverem definidas e ele ainda não existir.
if [ -n "$ADMIN_EMAIL" ] && [ -n "$ADMIN_PASSWORD" ]; then
    echo "==> Garantindo usuário administrador"
    php artisan admin:criar --email="$ADMIN_EMAIL" --nome="${ADMIN_NOME:-Admin}" --senha="$ADMIN_PASSWORD" || true
fi

# Caches de produção: rota, config e view pré-compiladas.
echo "==> Otimizando"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Subindo na porta ${PORT:-8080}"
exec php -S 0.0.0.0:"${PORT:-8080}" -t public
