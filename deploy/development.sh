#!/bin/bash

echo "Starting deployment..."

cd /var/www/mmc
git checkout develop
git pull
yarn
yarn production
composer update
php artisan migrate
php artisan optimize

echo "Deployment finished!"
