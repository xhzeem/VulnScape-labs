FROM python:3.11-slim-bookworm

RUN pip install flask requests

COPY app.py /app/app.py
WORKDIR /app

# Create a secret service for 8080
RUN mkdir /internal && echo "<h1>BLIND SSRF INTERNAL SERVICE</h1><p>Internal Flag: FLAG{SSRF_BLIND_TIME_BASED_OR_OUT_OF_BAND}</p>" > /internal/index.html

EXPOSE 8085 8080

# Start Flask app and a secondary internal server on 8080
CMD python3 -m http.server 8080 --directory /internal & python3 app.py
