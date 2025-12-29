FROM node:20-slim
WORKDIR /app
RUN apt-get update && apt-get install -y python3 && npm install express axios
COPY app.js /app/app.js
EXPOSE 8083 8080
CMD python3 -m http.server 8080 --directory /tmp & node app.js
