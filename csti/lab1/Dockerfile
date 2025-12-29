FROM php:8.2-apache
COPY index.php /var/www/html/
RUN sed -i 's/Listen 80/Listen 8090/' /etc/apache2/ports.conf && \
    sed -i 's/:80>/:8090>/' /etc/apache2/sites-available/000-default.conf
EXPOSE 8090
