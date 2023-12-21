#!/bin/bash
php artisan storage:link
set -e
ngrok http --host-header=lbaw23107.lbaw.fe.up.pt http://127.0.0.1:80 --domain typically-primary-lionfish.ngrok-free.app > /dev/null & #add ngrok for webhooks
cd /var/www
env >> /var/www/.env
php artisan clear-compiled
php artisan config:clear
php artisan queue:work --tries=1 &
php-fpm8.1 -D
nginx -g "daemon off;"
