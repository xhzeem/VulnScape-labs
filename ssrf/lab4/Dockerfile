FROM golang:1.21-alpine
COPY main.go .
RUN go build -o server main.go
RUN apk add --no-cache python3
EXPOSE 8084 8080
CMD python3 -m http.server 8080 --directory /tmp & ./server
