FROM php:8.2-apache
RUN apt-get update && apt-get install -y git zip unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
RUN composer require "twig/twig:^3.0"
COPY index.php /var/www/html/
RUN cp -r vendor /var/www/html/
EXPOSE 80
