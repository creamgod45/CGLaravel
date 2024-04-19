@echo off
composer install --optimize-autoloader
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan key:generate
php artisan optimize
php artisan config:clear &&  composer dump-autoload -o
npm install
echo Done
