FROM php:7.4.2-fpm-alpine

RUN apk add --no-cache --update \
        libzip-dev curl-dev libxml2-dev postgresql-dev icu-dev oniguruma-dev autoconf \
    && \
    apk add --update --no-cache --virtual .build-deps \
       g++ \
       gcc \
       gnupg \
       libgcc \
       make \
       alpine-sdk && \
    docker-php-ext-install \
        curl \
        xml \
        pdo_mysql \
        intl \
        phar \
        json \
        iconv \
        ctype \
        soap \
        dom \
        mbstring \
        tokenizer \
        pdo \
        bcmath \
        simplexml \
        sockets \
        opcache \
        zip \
        pcntl \
        xmlwriter && \
    pecl install xdebug-2.9.0 && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps

RUN set -ex \
    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS imagemagick-dev libtool \
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && pecl install imagick-3.4.3 \
    && docker-php-ext-enable imagick \
    && apk add --no-cache --virtual .imagick-runtime-deps imagemagick \
    && apk del .phpize-deps

RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_handler=dbgp' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_port=9001' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_autostart=1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_log=/tmp/xdebug.log' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini

RUN chmod 777 -R /tmp