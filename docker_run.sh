#!/bin/bash
set -e
ngrok http http://127.0.0.1:80 --domain typically-primary-lionfish.ngrok-free.app > /dev/null & #add ngrok for webhooks
cd /var/www
env >> /var/www/.env
php artisan clear-compiled
php artisan config:clear
php artisan queue:work &
php-fpm8.1 -D
nginx -g "daemon off;"
