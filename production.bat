@echo off
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan key:generate
php artisan optimize
php artisan config:clear &&  composer dump-autoload -o
npm install
npm run build
echo Done
REM config/app.php debugbar
REM public copy to root
REM Remove all hot file is laravel dected local server or server assets 
