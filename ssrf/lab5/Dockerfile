FROM python:3.11-slim
WORKDIR /app
RUN pip install flask requests
COPY app.py /app/app.py
EXPOSE 80
CMD ["python", "app.py"]
