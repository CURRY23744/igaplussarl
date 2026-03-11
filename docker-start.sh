#!/bin/sh

# On remplace 80 par le port dynamique de Railway
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/sites-available/default

# On lance PHP-FPM (il va écouter sur le 9000 en interne)
php-fpm -D

# On lance Nginx (il va écouter sur le $PORT et envoyer le PHP au 9000)
nginx -g "daemon off;"