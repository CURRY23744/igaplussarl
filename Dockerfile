FROM php:8.2-fpm

# Install extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl libpng-dev libonig-dev libxml2-dev libsqlite3-dev nginx \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/tmp/temp.db
RUN touch /tmp/temp.db && composer install --no-dev --optimize-autoloader --no-scripts

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Config nginx (On écoute sur la variable d'environnement PORT)
RUN echo 'server { \n\
    listen 80; \n\
    root /var/www/html/public; \n\
    index index.php index.html; \n\
    location / { try_files $uri $uri/ /index.php?$query_string; } \n\
    location ~ \\.php$ { \n\
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/sites-available/default

COPY --chown=root:root docker-start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/bin/sh", "/start.sh"]