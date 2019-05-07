ARG TAG=7.3.5-fpm-alpine3.9

FROM php:$TAG

ENV build_deps \
		autoconf \
		libzip-dev

ENV persistent_deps \
		build-base \
		nano \
		unzip \
		php-xml \
		php-zip \
		git \
		mysql-client

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"


# Set working directory as
WORKDIR /var/www

# Make permission to workdir
RUN chown -R www-data:www-data ./* \
    && chown -R www-data:www-data ./.* \
    && find . -type f -exec chmod 644 {} \; \
    && find . -type d -exec chmod 775 {} \;

# Install buld and persistent deps with docker ext
RUN apk upgrade && apk update && \
    pecl channel-update pecl.php.net && \
    apk add --no-cache --virtual .build-dependencies $build_deps && \
    apk add --update --no-cache --virtual .persistent-dependencies $persistent_deps && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install zip \
        mysqli pdo pdo_mysql && \
    # install php redis extension
    printf "\n" | pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis

# Run install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run install xdebug and remove build deps
RUN apk update && \
    pecl install xdebug &&\
    docker-php-ext-enable xdebug && \
    apk del .build-dependencies

# Copy xdebug configuration for remote debugging
COPY ./workspace/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./workspace/xdebug.ini /etc/php/7.3/apache2/conf.d
RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini
