#!/bin/bash
composer install
chmod -R 777 storage
cp .env.example .env
php artisan key:generate
php artisan env:set --db_host=$1 --db_user=$2 --db_pass=$3  --db_new_database_name=$4
php artisan config:clear
php artisan create:db
php artisan migrate:fresh --seed
php artisan serve
