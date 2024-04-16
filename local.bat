@echo off
composer install --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan key:generate
php artisan optimize
php artisan config:clear &&  composer dump-autoload -o
npm install
echo Done
