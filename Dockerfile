FROM ubuntu:22.04

# Install dependencies
ENV DEBIAN_FRONTEND=noninteractive

ENV NODE_MAJOR=20


RUN apt-get update; 
RUN apt-get install -y ca-certificates curl gnupg
RUN mkdir -p /etc/apt/keyrings
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
RUN apt-get update; apt-get install -y --no-install-recommends libpq-dev nginx php8.1-fpm php8.1-mbstring php8.1-xml php8.1-pgsql php8.1-curl ca-certificates curl git zip unzip php-zip nodejs
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=compose
RUN rm /tmp/composer-setup.php

RUN curl https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-amd64.tgz -o /tmp/ngrok.tgz
RUN tar xvzf /tmp/ngrok.tgz -C /usr/local/bin
RUN rm /tmp/ngrok.tgz

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
RUN npm install
RUN npm run build
RUN php artisan config:clear
RUN php artisan clear-compiled
RUN php artisan optimize

RUN ngrok config add-authtoken 2YzpEOpjITWoALZPdAsUPRh4k6u_5v27kVin3zx676KCAXbEu

WORKDIR /
RUN apt-get purge -y curl git zip unzip nodejs
# Start command
CMD sh /docker_run.sh
