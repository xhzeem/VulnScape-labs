FROM php:8.2-cli-alpine

RUN apk add --no-cache composer
COPY . /app
WORKDIR /app
RUN composer install

EXPOSE 8089
CMD ["php", "-S", "0.0.0.0:8089"]
