FROM php:8.2-cli-alpine

RUN apk add --no-cache iputils

COPY index.php /app/index.php
WORKDIR /app

EXPOSE 9202
CMD ["php", "-S", "0.0.0.0:9202"]
