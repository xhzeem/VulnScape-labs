FROM python:3.11-slim-bookworm

RUN pip install flask requests

COPY app.py /app/app.py
WORKDIR /app

# Create a secret file for the internal service on 8080
RUN mkdir /internal && echo "<h1>SECRET PORT 8080</h1><p>Internal Flag: FLAG{SSRF_BYPASS_LOCAL_IP}</p>" > /internal/index.html

EXPOSE 8082 8080

# Start Flask app and a secondary internal server on 8080
CMD python3 -m http.server 8080 --directory /internal & python3 app.py
