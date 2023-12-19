docker compose up -d
composer install
npm install
Start-Job -ScriptBlock {& npm run dev}
Start-Job -ScriptBlock {& php artisan queue:listen --tries=1}
php artisan serve