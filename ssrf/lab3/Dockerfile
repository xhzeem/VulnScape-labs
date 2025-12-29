FROM node:20-slim
WORKDIR /app
RUN npm install express axios
COPY app.js /app/app.js
EXPOSE 80
CMD ["node", "app.js"]
