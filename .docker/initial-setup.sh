#!/bin/bash

#Install crypt key
php artisan key:generate

#Install passport clients
php artisan passport:install

#Install passport keys
php artisan passport:keys