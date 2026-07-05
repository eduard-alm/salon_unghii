FROM php:8.3-apache

# Extensie DB (config/config.php citește DB_* din env — vezi prompts/_ENV.md §6)
RUN docker-php-ext-install pdo_mysql

# mod_rewrite (URL-uri curate, .htaccess) + mod_headers (header() din functions.php / HSTS)
RUN a2enmod rewrite headers

# AllowOverride All pe /var/www — altfel .htaccess e ignorat de Apache
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Codul aplicației (inclusiv vendor/, comis în Git — vezi _ENV.md §9).
# .dockerignore exclude fișierele de dev (router.php, scripts/, config.local.php etc.)
COPY . .

EXPOSE 80
