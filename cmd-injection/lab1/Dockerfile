FROM php:8.2-cli-alpine

RUN apk add --no-cache iputils

COPY index.php /app/index.php
WORKDIR /app

EXPOSE 9201
CMD ["php", "-S", "0.0.0.0:9201"]
