#!/bin/bash

docker compose up -d
composer install
npm install
npm run dev > /dev/null &
php artisan queue:work &
php artisan serve
