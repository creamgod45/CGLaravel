@echo off
composer install --optimize-autoloader
php artisan optimize:clear
php artisan key:generate
php artisan optimize
php artisan config:clear &&  composer dump-autoload -o
npm install
echo Done
