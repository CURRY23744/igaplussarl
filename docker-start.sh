#!/bin/sh

# 1. On injecte le port de Railway dans la config Nginx
# Railway donne un port (ex: 1234), on doit dire à Nginx d'écouter dessus
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/sites-available/default

# 2. On lance PHP-FPM en arrière-plan (&)
php-fpm -D

# 3. On lance Nginx au PREMIER PLAN (indispensable pour Docker)
nginx -g "daemon off;"