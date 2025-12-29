FROM python:3.11-slim
WORKDIR /app
RUN pip install flask requests
COPY app.py /app/app.py
EXPOSE 8082 8080
CMD python3 -m http.server 8080 --directory /tmp & python3 app.py
