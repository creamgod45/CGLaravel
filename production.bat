@echo off
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan key:generate
php artisan optimize
php artisan config:clear &&  composer dump-autoload -o
npm run build
echo Done
