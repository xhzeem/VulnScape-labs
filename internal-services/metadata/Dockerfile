FROM nginx:alpine
COPY metadata.json /usr/share/nginx/html/metadata.json
RUN echo 'server { listen 80; location / { root /usr/share/nginx/html; } }' > /etc/nginx/conf.d/default.conf
EXPOSE 80
