FROM php:8.2-cli-alpine

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY index.php /app/index.php
WORKDIR /app

EXPOSE 9003
CMD ["php", "-S", "0.0.0.0:9003"]
