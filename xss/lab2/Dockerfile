FROM php:8.2-cli-alpine

RUN apk add --no-cache sqlite-dev

COPY index.php /app/index.php
WORKDIR /app
RUN touch /tmp/guestbook.db && chmod 666 /tmp/guestbook.db

EXPOSE 9102
CMD ["php", "-S", "0.0.0.0:9102"]
