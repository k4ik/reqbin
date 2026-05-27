FROM php:8.3-cli-alpine

RUN apk add --no-cache \
    sqlite \
    sqlite-dev \
    git \
    unzip \
    curl \
    linux-headers

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    opcache

COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader

COPY . .

RUN mkdir -p storage bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache || true

RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini \
 && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
 && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
 && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
 && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/opcache.ini \
 && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]