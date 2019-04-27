ARG TAG=7.3.4-fpm

FROM php:$TAG

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"

# Run upadate
RUN apt-get update -yqq && \
    apt-get install --no-install-recommends -y apt-utils && \
    pecl channel-update pecl.php.net

# Run install mysql
RUN apt-get install --no-install-recommends -y mysql-client && \
    docker-php-ext-install pdo_mysql

# Run install php redis extension
RUN printf "\n" | pecl install -o -f redis \
        &&  rm -rf /tmp/pear \
        &&  docker-php-ext-enable redis

# Install zip e unzip extension (for composer)
RUN apt-get update && apt-get install --no-install-recommends -y unzip libzip-dev && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install zip && \
    rm -rf /var/lib/apt/lists/*

# Run install git
RUN apt-get update && \
    apt-get install --no-install-recommends -y git && \
    rm -rf /var/lib/apt/lists/*

# Run install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run install xdebug
RUN apt-get update \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug && \
    rm -rf /var/lib/apt/lists/*

# Copy xdebug configuration for remote debugging
COPY ./workspace/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./workspace/xdebug.ini /etc/php/7.3/apache2/conf.d
RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

# Run clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog