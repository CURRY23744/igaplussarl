#!/bin/sh
php-fpm -D
# Attendre que le socket soit prêt
while [ ! -S /var/run/php/php8.2-fpm.sock ]; do
    sleep 1
done
nginx -g "daemon off;"