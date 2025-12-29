FROM php:8.2-apache
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev python3 && docker-php-ext-install curl
COPY index.php /var/www/html/
RUN sed -i 's/Listen 80/Listen 8081/' /etc/apache2/ports.conf && \
    sed -i 's/:80>/:8081>/' /etc/apache2/sites-available/000-default.conf
EXPOSE 8081 8080
CMD python3 -m http.server 8080 --directory /tmp & apache2-foreground
