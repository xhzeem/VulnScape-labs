FROM node:20-alpine

COPY . /app
WORKDIR /app
RUN npm install

# Create a simple static service for 8080
RUN mkdir /internal && echo "<h1>NODE INTERNAL SERVICE</h1><p>Internal Flag: FLAG{SSRF_NODE_EXPRESS_WHITELIST_BYPASS}</p>" > /internal/index.html
RUN npm install -g http-server

EXPOSE 8083 8080

# Start Express app and http-server on 8080
CMD node app.js & http-server /internal -p 8080 -a 127.0.0.1
