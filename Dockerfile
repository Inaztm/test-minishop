FROM hitalos/laravel:latest

RUN docker-php-ext-install bcmath

COPY ./www /var/www

RUN composer install
