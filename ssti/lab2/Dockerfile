FROM node:20-slim
WORKDIR /app
RUN npm install express ejs
COPY app.js /app/app.js
EXPOSE 8088
CMD ["node", "app.js"]
