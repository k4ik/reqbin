FROM php:8.3-cli-alpine AS builder

RUN apk add --no-cache \
    sqlite-dev \
    git \
    unzip \
    linux-headers

RUN docker-php-ext-install pdo pdo_sqlite opcache

COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN --mount=type=cache,target=/root/.composer/cache \
    /usr/usr/bin/composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN --mount=type=cache,target=/root/.composer/cache \
    /usr/usr/bin/composer dump-autoload --optimize --strict-ambiguous


FROM php:8.3-cli-alpine AS runner

RUN apk add --no-cache sqlite-libs

COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

WORKDIR /var/www

COPY --from=builder --chown=www-data:www-data /var/www /var/www

RUN { \
        echo "opcache.enable=1"; \
        echo "opcache.memory_consumption=128"; \
        echo "opcache.interned_strings_buffer=8"; \
        echo "opcache.max_accelerated_files=10000"; \
        echo "opcache.validate_timestamps=0"; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]