FROM node:20-alpine

COPY . /app
WORKDIR /app
RUN npm install

EXPOSE 8088
CMD ["node", "app.js"]
