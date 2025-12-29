#!/usr/bin/env python3
"""
Simple Flask server vulnerable to SSTI (Server-Side Template Injection)
WARNING: This is intentionally vulnerable for educational purposes only!
"""

from flask import Flask, request, render_template_string

app = Flask(__name__)

# Vulnerable template that directly renders user input
TEMPLATE = """
<!DOCTYPE html>
<html>
<head>
    <title>SSTI Vulnerable Server</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            text-align: center;
        }
        .form-group {
            margin: 20px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        button:hover {
            background: #764ba2;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-left: 4px solid #667eea;
            border-radius: 5px;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔥 Greeting Generator</h1>
        <div class="warning">
            ⚠️ Educational Lab - Intentionally Vulnerable to SSTI
        </div>
        <form method="POST">
            <div class="form-group">
                <label for="name">Enter your name:</label>
                <input type="text" id="name" name="name" placeholder="e.g., John" required>
            </div>
            <button type="submit">Generate Greeting</button>
        </form>
        {% if result %}
        <div class="result">
            <strong>Greeting:</strong><br>
            {{ result }}
        </div>
        {% endif %}
    </div>
</body>
</html>
"""

@app.route('/', methods=['GET', 'POST'])
def index():
    result = None
    if request.method == 'POST':
        name = request.form.get('name', '')
        # VULNERABLE: Directly rendering user input in template
        # This allows SSTI attacks like {{7*7}} or {{config}}
        greeting_template = f"Hello, {name}! Welcome to our server."
        result = render_template_string(greeting_template)
    
    return render_template_string(TEMPLATE, result=result)

@app.route('/health')
def health():
    return {'status': 'running', 'vulnerability': 'SSTI'}, 200

if __name__ == '__main__':
    print("=" * 60)
    print("🔥 SSTI Vulnerable Server Starting...")
    print("=" * 60)
    print("⚠️  WARNING: This server is intentionally vulnerable!")
    print("📍 Server running on: http://localhost:7788")
    print("🎯 Try payloads like: {{7*7}} or {{config}}")
    print("=" * 60)
    app.run(host='0.0.0.0', port=7788, debug=True)
