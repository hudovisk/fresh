#!/bin/bash

#Run composer install
composer install

#Run Migrations
php artisan migrate

php-fpm