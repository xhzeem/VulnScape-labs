from flask import Flask, request, render_template_string
import requests

app = Flask(__name__)

@app.route('/')
def index():
    url = request.args.get('url')
    if not url:
        return '''
        <html>
            <body style="font-family: sans-serif; padding: 50px; background: #fdf2f8;">
                <div style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
                    <h1>URL Health Checker</h1>
                    <p>Enter a URL to check if it's up. (Blind SSRF)</p>
                    <form>
                        <input type="text" name="url" placeholder="http://example.com" style="width: 100%; padding: 10px;">
                        <button type="submit" style="margin-top: 10px; padding: 10px; background: #ec4899; color: white; border: none; cursor: pointer;">Check</button>
                    </form>
                </div>
            </body>
        </html>
        '''
    
    try:
        # Blind: We don't return the content, only status
        requests.get(url, timeout=3)
        return "URL is up and reachable!"
    except Exception:
        return "URL is down or unreachable!"

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)
