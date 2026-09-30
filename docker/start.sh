#!/bin/sh
set -e

echo "==> Preparando a aplicação"

# A APP_KEY precisa ser "base64:" seguido de 32 bytes codificados. Um valor
# vazio, truncado ou em outro formato derruba a aplicação inteira com
# "Unsupported cipher or incorrect key length" — e o erro só aparece quando
# a primeira página é servida, não durante o build.
case "$APP_KEY" in
    base64:*)
        echo "==> APP_KEY definida"
        ;;
    *)
        CHAVE="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
        export APP_KEY="$CHAVE"

        echo ""
        echo "########################################################"
        echo "#  APP_KEY ausente ou invalida. Gerando uma agora."
        echo "#"
        echo "#  COPIE a linha abaixo e cole em:"
        echo "#  Render > Environment > APP_KEY"
        echo "#"
        echo "#  $CHAVE"
        echo "#"
        echo "#  Sem fixar a chave, cada reinicio gera outra e todas"
        echo "#  as sessoes caem."
        echo "########################################################"
        echo ""
        ;;
esac

# O Postgres do Render pode levar alguns segundos para aceitar conexões
# depois que o container sobe. Sem esperar, a migration falha e o deploy
# inteiro morre por um problema que se resolve sozinho em 10 segundos.
echo "==> Aguardando o banco responder"
tentativa=1
until php artisan db:show --quiet >/dev/null 2>&1; do
    if [ "$tentativa" -ge 20 ]; then
        echo "!! Banco nao respondeu apos 20 tentativas."
        echo "!! Verifique se DB_URL esta definida nas variaveis de ambiente."
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
    echo "==> Garantindo usuario administrador"
    php artisan admin:criar --email="$ADMIN_EMAIL" --nome="${ADMIN_NOME:-Admin}" --senha="$ADMIN_PASSWORD" || true
fi

# Caches de produção: rota, config e view pré-compiladas.
echo "==> Otimizando"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Subindo na porta ${PORT:-8080}"
exec php -S 0.0.0.0:"${PORT:-8080}" -t public
