FROM ubuntu:22.04

# Install dependencies
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update; apt-get install -y --no-install-recommends libpq-dev nginx php8.1-fpm php8.1-mbstring php8.1-xml php8.1-pgsql php8.1-curl ca-certificates curl git zip unzip php-zip
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=compose
RUN rm /tmp/composer-setup.php

# Copy project code and install project dependencies
COPY --chown=www-data . /var/www/

# Copy project configurations
COPY ./etc/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./etc/nginx/default.conf /etc/nginx/sites-enabled/default
COPY .env_production /var/www/.env
COPY docker_run.sh /docker_run.sh

WORKDIR /var/www
ENV COMPOSER_ALLOW_SUPERUSER=1

# Ensure that dependencies are available
RUN compose install
RUN php artisan config:clear
RUN php artisan clear-compiled
RUN php artisan optimize

WORKDIR /
RUN apt-get purge -y curl git zip unzip
# Start command
CMD sh /docker_run.sh
