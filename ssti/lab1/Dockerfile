FROM python:3.11-slim-bookworm

RUN pip install flask

COPY app.py /app/app.py
WORKDIR /app

EXPOSE 8087
CMD ["python", "app.py"]
