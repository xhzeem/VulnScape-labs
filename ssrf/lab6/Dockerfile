FROM php:8.2-cli-alpine

RUN apk add --no-cache curl-dev && docker-php-ext-install curl

COPY index.php /app/index.php
WORKDIR /app

# Create a secret service for 8080
RUN mkdir /internal && echo "<h1>EXPERT LEVEL INTERNAL SERVICE</h1><p>Internal Flag: FLAG{SSRF_GOPHER_REDIS_SSRF_FULL_PWN}</p>" > /internal/index.html

ENV PHP_CLI_SERVER_WORKERS=4

EXPOSE 8086 8080

# Start PHP app and a secondary internal server on 8080
CMD php -S 0.0.0.0:8086 index.php & php -S 127.0.0.1:8080 -t /internal
