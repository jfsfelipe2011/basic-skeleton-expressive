FROM alpine:3.8

ARG BUILD_DATE
ARG VCS_REF

LABEL org.label-schema.build-date=$BUILD_DATE \
      org.label-schema.vcs-url="https://github.com/phpearth/docker-php.git" \
      org.label-schema.vcs-ref=$VCS_REF \
      org.label-schema.schema-version="1.0" \
      org.label-schema.vendor="PHP.earth" \
      org.label-schema.name="docker-php" \
      org.label-schema.description="Docker For PHP Developers - Docker image with PHP 7.2, Nginx, and Alpine" \
      org.label-schema.url="https://github.com/phpearth/docker-php"

ENV \
    # When using Composer, disable the warning about running commands as root/super user
    COMPOSER_ALLOW_SUPERUSER=1 \
    # Persistent runtime dependencies
    DEPS="nginx \
        nginx-mod-http-headers-more \
        php7.2 \
        php7.2-pdo \
        php7.2-pdo_mysql \
        php7.2-phar \
        php7.2-bcmath \
        php7.2-calendar \
        php7.2-mbstring \
        php7.2-exif \
        php7.2-ftp \
        php7.2-openssl \
        php7.2-zip \
        php7.2-sysvsem \
        php7.2-sysvshm \
        php7.2-sysvmsg \
        php7.2-shmop \
        php7.2-sockets \
        php7.2-zlib \
        php7.2-bz2 \
        php7.2-curl \
        php7.2-simplexml \
        php7.2-xml \
        php7.2-opcache \
        php7.2-dom \
        php7.2-xmlreader \
        php7.2-xmlwriter \
        php7.2-tokenizer \
        php7.2-ctype \
        php7.2-session \
        php7.2-fileinfo \
        php7.2-iconv \
        php7.2-json \
        php7.2-posix \
        php7.2-fpm \
        curl \
        ca-certificates \
        runit"

# Set timezone to America/Sao_Paulo
RUN apk add --update --virtual .build-deps \
    tzdata \
    && \
    cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime \
    && \
    echo "America/Sao_Paulo" > /etc/timezone

# PHP.earth Alpine repository for better developer experience
ADD https://repos.php.earth/alpine/phpearth.rsa.pub /etc/apk/keys/phpearth.rsa.pub

RUN set -x \
    && echo "https://repos.php.earth/alpine/v3.8" >> /etc/apk/repositories \
    && apk add --no-cache $DEPS \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

COPY config/nginx /

EXPOSE 80

CMD ["/sbin/runit-wrapper"]

COPY ./ /var/www/html
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:1.6 /usr/bin/composer /usr/bin/composer

# Project dependecies
RUN composer global require hirak/prestissimo \
    ; \
    composer install \
        --no-dev \
        --prefer-dist \
        --optimize-autoloader \
    ; \
composer clearcache

# Environment php-fpm
RUN sed -e 's/;clear_env = no/clear_env = no/' -i /etc/php/7.2/php-fpm.d/www.conf