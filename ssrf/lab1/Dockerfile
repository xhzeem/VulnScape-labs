FROM php:8.2-cli-alpine

RUN apk add --no-cache curl-dev && docker-php-ext-install curl

COPY index.php /app/index.php
WORKDIR /app

# Create a secret directory for the internal service on 8080
RUN mkdir /internal && echo "<h1>INTERNAL SECRET SERVICE</h1><p>Flag: FLAG{SSRF_PORT_8080_DISCOVERY}</p>" > /internal/index.html

ENV PHP_CLI_SERVER_WORKERS=4

EXPOSE 8081 8080

# Start two PHP servers: one for the main app, one for the internal service
CMD php -S 0.0.0.0:8081 index.php & php -S 127.0.0.1:8080 -t /internal
