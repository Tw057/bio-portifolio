#!/bin/sh
set -e

echo "==> Preparando a aplicação"

# APP_KEY: sem ela o Laravel não sobe. Em produção vem da variável
# de ambiente; aqui é só uma rede de segurança para o primeiro deploy.
if [ -z "$APP_KEY" ]; then
    echo "!! APP_KEY não definida — gerando uma temporária."
    echo "!! Defina APP_KEY nas variáveis de ambiente do Render."
    php artisan key:generate --force
fi

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
