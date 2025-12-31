FROM golang:1.21-alpine

COPY . /app
WORKDIR /app
RUN go mod init ssrf-lab4 && go build -o main .

# Create a simple static service for 8080 using busybox
RUN mkdir /internal && echo "<h1>GO INTERNAL SERVICE</h1><p>Internal Flag: FLAG{SSRF_DNS_REBINDING_VULN}</p>" > /internal/index.html

EXPOSE 8084 8080

# Start Go app
CMD ["./main"]
