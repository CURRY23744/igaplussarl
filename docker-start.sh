#!/bin/sh

# Remplace ${PORT} dans la config Nginx par la vraie valeur fournie par Railway
sed -i "s/\${PORT}/${PORT}/g" /etc/nginx/sites-available/default

# Lancer PHP-FPM en arrière-plan
php-fpm -D

# Lancer Nginx au premier plan
nginx -g "daemon off;"