# ─────────────────────────────────────────────────────────────
# Etapa 1: compilar o CSS com Node.
# Sai da imagem final — o servidor não precisa de Node para rodar.
# ─────────────────────────────────────────────────────────────
FROM node:22-alpine AS assets

WORKDIR /app

COPY package*.json vite.config.js ./
RUN npm ci

COPY resources/ resources/
COPY public/ public/
RUN npm run build

# ─────────────────────────────────────────────────────────────
# Etapa 2: a aplicação
# ─────────────────────────────────────────────────────────────
# 8.4 e não 8.3: o composer.lock foi gerado num PHP mais novo e travou
# pacotes do Symfony que exigem >= 8.4.1. A imagem precisa acompanhar o lock.
FROM php:8.4-cli-alpine

# pdo_pgsql para o Postgres; as demais são exigências do Laravel.
RUN apk add --no-cache postgresql-dev libzip-dev icu-dev oniguruma-dev \
    && docker-php-ext-install pdo_pgsql pgsql zip intl opcache bcmath

# OPcache: compila o PHP uma vez e reutiliza. Em plano gratuito,
# onde CPU é escassa, isso é a diferença entre rápido e lento.
RUN { \
      echo 'opcache.enable=1'; \
      echo 'opcache.memory_consumption=128'; \
      echo 'opcache.max_accelerated_files=10000'; \
      echo 'opcache.validate_timestamps=0'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dependências primeiro: essa camada só refaz quando o composer.json muda.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
COPY --from=assets /app/public/build public/build

RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["sh", "docker/start.sh"]
