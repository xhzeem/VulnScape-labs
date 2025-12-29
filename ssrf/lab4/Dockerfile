FROM golang:1.21-alpine
COPY main.go .
RUN go build -o server main.go
EXPOSE 80
CMD ["./server"]
